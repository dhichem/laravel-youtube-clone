<template>
    <div class="flex flex-col gap-6 w-full">
        <div class="flex flex-col gap-4">
            <div class="flex gap-4" v-for="(item, index) in replies" :key="index">
                <img
                    class="rounded-full"
                    style="width: 40px; height: 40px"
                    :src="item.user.channel.photo ? item.user.channel.photo : '/def_profile.png'"
                />

                <div class="flex flex-col gap-1">
                    <span>{{ item.user.channel.name }}</span>
                    <span>{{ item.content }}</span>
                    <div class="flex">
                        <like-unlike-button :like-count-prop="item.upVotesCount" :unlike-count-prop="item.downVotesCount"
                        :is-reacted-to-prop="item.checkIfReacted" :owner="item.user_id"
                        :entity-id="item.id" :entity-type="'comment'"></like-unlike-button>
                    </div>
                </div>
            </div>
            <div class="flex justify-left">
                <button @click="fetchReplies(1)" class="py-2 px-3 rounded-lg text-white bg-[#ff302f] hover:bg-[#ff7c7c]" :class="current_page == last_page ? 'pointer-events-none bg-[#ff7c7c]' : ''">Show more</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            replies: [],
            content: "",
            last_page: 0,
            per_page: 10,
            current_page: 1,
            showButton: false
        };
    },
    props: {
        comment: {
            type: Object,
            required: true,
            default: {},
        }
    },
    mounted() {
        this.fetchReplies();
    },
    methods: {
        test() {
            const textarea = document.getElementById("autoGrowTextarea");
            textarea.addEventListener("input", function () {
                this.style.height = "auto"; // Reset height
                this.style.height = this.scrollHeight + "px"; // Set height based on content
            });
        },
        fetchReplies(step = 0) {
            if(this.current_page == this.last_page)
                return;
            this.current_page += step;
            axios.get(`/comments/${this.comment.id}/replies?page=${this.current_page}&per_page=${this.per_page}`).then((res) => {
                this.replies = this.replies.concat(res.data.data);
                this.current_page = res.data.current_page;
                this.last_page = res.data.last_page;
            })
        },
        postComment() {},
    },
};
</script>
