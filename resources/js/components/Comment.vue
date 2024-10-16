<template>
    <div class="flex flex-col gap-6 w-full">
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
                    @focus="showButton = true"
                ></textarea>
                <div v-if="showButton" class="flex gap-3 ml-auto">
                    <button @click="showButton = false">Cancel</button>
                    <button
                        class="py-2 px-3 rounded-lg text-white"
                        :class="
                            content.length != 0
                                ? 'bg-[#ff302f]'
                                : 'bg-[#f79a9a] pointer-events-none'
                        "
                        @click="postComment()"
                    >
                        Comment
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 w-full">
            <div class="flex gap-4" v-for="item in comments" :key="item.id">
                <img
                    class="rounded-full"
                    style="width: 40px; height: 40px"
                    :src="
                        item.user.channel.photo
                            ? item.user.channel.photo
                            : '/def_profile.png'
                    "
                />

                <div class="flex flex-col gap-1 w-full">
                    <span>{{ item.user.channel.name }}</span>
                    <span>{{ item.content }}</span>
                    <div class="flex gap-3">
                        <like-unlike-button
                            :like-count-prop="item.upVotesCount"
                            :unlike-count-prop="item.downVotesCount"
                            :is-reacted-to-prop="item.checkIfReacted"
                            :owner="item.user_id"
                            :entity-id="item.id"
                            :entity-type="'comment'"
                        ></like-unlike-button>
                        <button
                            @click="showReplyPost[item.id] = true; contentR[item.id] = ''" class="text-gray-950 py-1 px-2 hover:bg-[#ffc1c1] rounded-lg"
                        >
                            Reply
                        </button>
                    </div>
                    <div v-if="showReplyPost[item.id]" class="flex gap-4">
                        <img
                            class="rounded-full"
                            style="width: 40px; height: 40px"
                            :src="profileImg"
                        />

                        <div class="flex flex-col gap-2 w-full">
                            <textarea
                                :id="'autoGrowTextareaR'+item.id"
                                name="content"
                                placeholder="Add a comment..."
                                class="border-b-2 w-full focus:outline-none focus:border-b-2 focus:border-gray-900"
                                style="width: 100%; overflow: hidden"
                                rows="1"
                                v-model="contentR[item.id]"
                                @input="testR(item.id)"
                            ></textarea>
                            <div class="flex gap-3 ml-auto">
                                <button @click="showReplyPost[item.id] = false">
                                    Cancel
                                </button>
                                <button
                                    class="py-2 px-3 rounded-lg text-white"
                                    :class="
                                        contentR[item.id].length != 0
                                            ? 'bg-[#ff302f]'
                                            : 'bg-[#f79a9a] pointer-events-none'
                                    "
                                    @click="postComment(item)"
                                >
                                    Comment
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        @click="toggleReplies(item)"
                        v-if="item.repliesCount > 0"
                        class="text-[#ff302f] px-3 py-1 rounded-lg hover:bg-[#ffbdbd] w-fit cursor-pointer"
                    >
                        {{ item.repliesCount }} Replies
                    </div>
                    <div>
                        <Reply
                            :ref="'reply-'+item.id"
                            v-if="item.show"
                            :comment="item"
                            :key="item.id + '-vote'"
                        ></Reply>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button
                    @click="fetchComments(1)"
                    class="py-2 px-3 rounded-lg text-white bg-[#ff302f] hover:bg-[#ff7c7c]"
                    :class="
                        current_page == last_page
                            ? 'pointer-events-none bg-[#ff7c7c]'
                            : ''
                    "
                >
                    Show more
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Reply from "./Reply.vue";

export default {
    data: function () {
        return {
            comments: [],
            content: "",
            last_page: 0,
            per_page: 10,
            current_page: 1,
            showButton: false,
            showReplyPost: {},
            contentR: {}
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
        },
    },
    components: {
        Reply,
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
        testR(id) {
            const textarea = document.getElementById(`autoGrowTextareaR${id}`);
            textarea.addEventListener("input", function () {
                this.style.height = "auto"; // Reset height
                this.style.height = this.scrollHeight + "px"; // Set height based on content
            });
        },
        fetchComments(step = 0) {
            if (this.current_page == this.last_page) return;
            this.current_page += step;
            axios
                .get(
                    `/videos/${this.video.id}/comments?page=${this.current_page}&per_page=${this.per_page}`
                )
                .then((res) => {
                    this.comments = this.comments.concat(res.data.data);
                    this.current_page = res.data.current_page;
                    this.last_page = res.data.last_page;
                });
        },
        toggleReplies(item) {
            item.show = !item.show;
            // this.$refs.reply.fetchReplies();
        },
        postComment(item = null) {
            if (!window.__auth()) {
                window.location.href = window.location.origin + "/login";
                return;
            }

            if ((!item && this.content.length == 0) || (item && this.contentR[item.id]?.length == 0)) return;
            console.log(item, this.content)
            const payload = {
                content: item ? this.contentR[item.id] : this.content,
                comment_id: item ? item.id : null,
            };

            axios
                .post(`/videos/${this.video.id}/comments`, payload)
                .then((res) => {
                    if(!item) {
                        this.showButton = false;
                        this.content = "";
                        this.comments.unshift(res.data);
                    } else {
                        this.showReplyPost[item.id] = false;
                        this.contentR[item.id] = "";
                        if(item.show)
                            this.$refs[`reply-${item.id}`].insertNewReply(res.data);
                        else
                            this.toggleReplies(item);
                    }
                });
        },
    },
};
</script>
