<template>
    <div class="flex flex-col gap-2 w-full">
        <textarea
            id="autoGrowTextarea"
            name="content"
            placeholder="Add a comment..."
            class="border-b-2 focus:outline-none focus:border-b-2 focus:border-gray-900"
            style="width: 100%;overflow:hidden"
            rows="1"
            v-model="content"
            @input="test"
        ></textarea>
        <button class="ml-auto py-2 px-3 rounded-lg text-white" :class="content.length != 0 ? 'bg-[#ff302f]' : 'bg-[#f79a9a] pointer-events-none'">
            Comment
        </button>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            content: ""
        };
    },
    props: {},
    methods: {
        test() {
            const textarea = document.getElementById("autoGrowTextarea");
            textarea.addEventListener("input", function () {
                this.style.height = "auto"; // Reset height
                this.style.height = this.scrollHeight + "px"; // Set height based on content
            });
        },
        postComment() {

        }
    },
};
</script>
