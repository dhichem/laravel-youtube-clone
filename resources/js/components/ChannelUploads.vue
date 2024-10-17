<template>
    <div class="bg-white p-3 w-[70%] mx-auto flex flex-col">
        <div v-if="!fileSelected" class="flex flex-col items-center">
            <input
                multiple
                type="file"
                accept="video/*"
                @change="upload"
                id="uploaded-videos"
                ref="videos"
                class="hidden"
            />
            <img
                @click="selectVideos"
                class="cursor-pointer"
                style="width: 100px"
                src="/upload-icon.svg"
                alt=""
            />
            <p>Click on the upload icon to upload videos</p>
        </div>
        <div v-else>
            <div class="flex w-full px-6 py-3" v-for="(item, index) in videos" :key="index">
                <img
                    class="bg-gray-400"
                    style="width: 220px; height: 150px"
                    :src="item.percentage ? item.thumbnail : '/video_default_thumbnail.png'"
                    alt=""
                />
                <div class="flex flex-col items-start gap-2 w-full ml-12">
                    <a v-if="item.percentage && item.percentage == 100" target="_blank":href="`/videos/${item.id}`">{{ item.title }}</a>
                    <span v-else class="text-xl font-semibold">{{ item.title || item.name }}</span>
                    <span>{{item.percentage ? item.percentage == 100 ? 'Processing completed' : 'Processing...' : 'Uploading...'}} ({{progressValue[item.name] || item.percentage}}%)</span>
                    <div id="bar" class="bg-gray-300 w-full h-2 rounded-xl">
                        <div
                            id="progress-bar"
                            :class="`bg-green-600 h-full rounded-xl`"
                            :style="`width: ${progressValue[item.name] || item.percentage}%; transition: width 0.5s ease-in-out;`"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data: function () {
        return {
            fileSelected: false,
            videos: [],
            progressValue: {},
            uploads: [],
            intervals: []
        };
    },
    props: {
        channel: {
            type: Object,
            required: true,
        },
    },
    methods: {
        selectVideos() {
            document.getElementById("uploaded-videos").click();
        },
        upload() {
            this.fileSelected = true;
            this.videos = Array.from(this.$refs.videos.files);

            const uploads = this.videos.map((video) => {
                this.progressValue[video.name] = 0;
                const formData = new FormData();
                formData.append("video", video);
                formData.append("title", video.name);
                console.log("dddd", formData);

                return axios.post(
                    `/channels/${this.channel.id}/videos`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                        onUploadProgress: (event) => {
                            this.progressValue[video.name] = Math.floor(event.loaded / event.total * 100);
                        }
                    }
                ).then((res) => {
                    this.uploads = [
                        ...this.uploads,
                        res.data
                    ]
                });
            });

            axios.all(uploads).then(() => {
                this.videos = this.uploads;

                this.videos.forEach(video => {
                    this.intervals[video.id] = setInterval(() => {
                        axios.get(`/videos/${video.id}`).then((res) => {
                            if(res.data.percentage == 100) {
                                clearInterval(this.intervals[video.id])
                            }

                            this.videos = this.videos.map(video => {
                                if(video.id == res.data.id) {
                                    return res.data;
                                }
                                return video;
                            })
                        })
                    }, 3000)
                })
            });
        },
    },
};
</script>
