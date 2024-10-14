<template>
    <div class="flex flex-col gap-2 w-full">
        <div class="flex gap-4">
            <img
                class="rounded-full"
                style="width: 40px; height: 40px"
                :src="profileImg"
            />

            <div class="flex flex-col gap-2 w-full">
                <textarea
                    id="autoGrowTextarea"
                    name="content"
                    placeholder="Add a comment..."
                    class="border-b-2 focus:outline-none focus:border-b-2 focus:border-gray-900"
                    style="width: 100%; overflow: hidden"
                    rows="1"
                    v-model="content"
                    @input="test"
                ></textarea>
                <button
                    class="ml-auto py-2 px-3 rounded-lg text-white"
                    :class="
                        content.length != 0
                            ? 'bg-[#ff302f]'
                            : 'bg-[#f79a9a] pointer-events-none'
                    "
                >
                    Comment
                </button>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex gap-4" v-for="(item, index) in comments" :key="index">
                <img
                    class="rounded-full"
                    style="width: 40px; height: 40px"
                    :src="item.user.channel.photo ? item.user.channel.photo : '/def_profile.png'"
                />

                <div class="flex flex-col gap-1">
                    <span>{{ item.user.channel.name }}</span>
                    <span>{{ item.content }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            comments: [],
            content: ""
        };
    },
    props: {
        profileImg: {
            type: String,
            required: true,
            default: "/def_profile.png",
        },
        video: {
            type: Object,
            required: true,
            default: {},
        }
    },
    mounted() {
        this.fetchComments();
    },
    methods: {
        test() {
            const textarea = document.getElementById("autoGrowTextarea");
            textarea.addEventListener("input", function () {
                this.style.height = "auto"; // Reset height
                this.style.height = this.scrollHeight + "px"; // Set height based on content
            });
        },
        fetchComments() {
            axios.get(`/videos/${this.video.id}/comments`).then((res) => {
                this.comments = res.data.data;
            })
        },
        postComment() {},
    },
};
</script>
