<template>
    <div class="flex items-center gap-2 bg-gray-300 rounded-lg h-full px-3">
        <button class="rounded-l-lg flex gap-2 items-center"><img src="/like.svg" style="height: 20px;" alt="">{{ likeCount }}</button>
        <div style="border-left:1px solid #000;height:23px"></div>
        <button class="rounded-r-lg flex gap-2 items-center"><img src="/unlike.svg" style="height: 20px;" alt="">{{ likeCount }}</button>
    </div>
</template>

<script>
  export default {
    props: {
        likeCount: {
            type: Number,
            required: true,
            default: 0
        },
        unlikeCount: {
            type: Number,
            required: true,
            default: 0
        },
        isReactedToProp: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    data: function () {
        return {
            isReactedTo: this.isReactedToProp
        }
    },
    methods: {
        toggleSubscription() {
            if(!window.__auth()) {
                window.location.href = window.location.origin + '/login';
            } else {
                if(this.isSubscribed) {
                    Axios.delete(`/channels/${this.subscription.channel_id}/subscriptions/${this.subscription.id}`).then(() => {
                        this.subscription = {};
                        this.isSubscribed = false;
                    });
                } else {
                    console.log('dfdffdfdfd')
                    Axios.post(`/channels/${this.channel.id}/subscriptions`).then((res) => {
                        this.subscription = res;
                        this.isSubscribed = true;
                    })
                }
            }
        }
    }
  };
</script>
