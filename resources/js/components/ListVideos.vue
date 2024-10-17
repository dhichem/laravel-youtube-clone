<template>
    <div>
        <div v-if="videos.length != 0" class="flex flex-wrap gap-5 w-full justify-center">
            <div
                v-for="(item, index) in videos"
                :key="index"
                class="flex flex-col gap-1 w-[210px] cursor-pointer"
                @click="goToVideo(item)"
            >
                <img
                    :src="'/video_default_thumb.png'"
                    style="width: 100%"
                    class="rounded-xl"
                    alt=""
                />
                <span class="font-bold">{{ item.title }}</span>
                <div>
                    <span
                        >{{ item.viewsCount }} {{ "views" }} •
                        {{ item.created_at }}</span
                    >
                </div>
            </div>
        </div>
        <div v-else class="flex flex-col w-full items-center">
            <img src="/no-content.png" style="width: 170px;"alt="">
            <span class="text-lg">This channel has no content</span>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            videos: [],
            last_page: 0,
            per_page: 20,
            current_page: 1,
            showButton: false,
        };
    },
    props: {
        type: {
            type: String,
            required: false,
            default: "channel",
        },
        channel: {
            type: Object,
            required: false,
            default: null,
        },
    },
    mounted() {
        if (this.channel) this.fetchChannelVideos();
        else this.fetchVideos();
    },
    methods: {
        fetchVideos(step = 0) {
            if (this.current_page == this.last_page) return;
            this.current_page += step;
            axios
                .get(
                    `/videos?page=${this.current_page}&per_page=${this.per_page}`
                )
                .then((res) => {
                    this.videos = this.videos.concat(res.data.data);
                    this.current_page = res.data.current_page;
                    this.last_page = res.data.last_page;
                });
        },
        fetchChannelVideos(step = 0) {
            if (this.current_page == this.last_page) return;
            this.current_page += step;
            axios
                .get(
                    `/channels/${this.channel.id}/getVideos?page=${this.current_page}&per_page=${this.per_page}`
                )
                .then((res) => {
                    this.videos = this.videos.concat(res.data.data);
                    this.current_page = res.data.current_page;
                    this.last_page = res.data.last_page;
                });
        },
        goToVideo(item) {
            window.location.assign(`/videos/${item.id}`);
        }
    },
};
</script>
