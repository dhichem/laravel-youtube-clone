<template>
    <button
        @click="toggleSubscription"
        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-[#ff302f] hover:bg-[#ff5c5c] rounded-lg focus:ring-4 focus:outline-none"
    >
        {{ isSubscribed ? "Unsubscribe" : "Subscribe" }}
    </button>
</template>

<script>
import Axios from 'axios';

  export default {
    props: {
        isSubscribedProp: {
            type: Boolean,
            required: true,
            default: false
        },
        subscriptionProp: {
            type: Object,
            required: true,
            default: {}
        },
        channel: {
            type: Object,
            required: true
        }
    },
    data: function () {
        return {
            isSubscribed: this.isSubscribedProp,
            subscription: this.subscriptionProp
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
