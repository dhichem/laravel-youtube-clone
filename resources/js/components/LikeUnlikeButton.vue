<template>
    <div class="flex items-center gap-2 bg-gray-300 rounded-lg h-full">
        <button @click="vote('up')" class="rounded-l-lg flex gap-2 px-2 h-full items-center"><ThumbUp :size="20" :fill="getUpReaction"></ThumbUp>{{ likeCountFormat }}</button>
        <div style="border-left:1px solid #000;height:23px"></div>
        <button @click="vote('down')" class="rounded-r-lg flex gap-2 px-2 h-full items-center"><ThumbDown :size="20" :fill="getDownReaction"></ThumbDown>{{ unlikeCountFormat }}</button>
    </div>
</template>

<script>
import numeral from 'numeral';
import ThumbUp from './icons/thumbUp.vue';
import ThumbDown from './icons/thumbDown.vue';
  export default {
    components: {
        ThumbUp,
        ThumbDown
    },
    props: {
        likeCountProp: {
            type: Number,
            required: true,
            default: 0
        },
        unlikeCountProp: {
            type: Number,
            required: true,
            default: 0
        },
        isReactedToProp: {
            type: Object,
            required: true,
            default: null
        },
        owner: {
            type: String,
            required: true,
            default: ""
        },
        entityId: {
            type: String,
            required: true,
            default: ""
        },
        entityType: {
            type: String,
            required: true,
            default: "video"
        }
    },
    data: function () {
        return {
            isReactedTo: this.isReactedToProp,
            likeCount: this.likeCountProp,
            unlikeCount: this.unlikeCountProp
        }
    },
    computed: {
        likeCountFormat() {
            return numeral(this.likeCount).format('0a');
        },
        unlikeCountFormat() {
            return numeral(this.unlikeCount).format('0a');
        },
        getUpReaction() {
            return this.isReactedTo ? this.isReactedTo.type == 'up' ? '#000' : 'none' : 'none';
        },
        getDownReaction() {
            return this.isReactedTo ? this.isReactedTo.type == 'down' ? '#000' : 'none' : 'none';
        }
    },
    methods: {
        vote(type) {
            if(!window.__auth()) {
                window.location.href = window.location.origin + '/login';
                return;
            }

            if((this.getUpReaction != 'none' && type == 'up') || (this.getDownReaction != 'none' && type == 'down') || window.__auth().id == this.owner) {
                return;
            }

            axios.post(`/votes/${this.entityId}/${type}/${this.entityType}`).then((res) => {
                this.isReactedTo = res.data;
                if(this.isReactedTo.type == 'up') {
                    this.likeCount += 1;
                    if(res.status == 200)
                        this.unlikeCount -= 1;
                }
                else {
                    this.unlikeCount += 1;
                    if(res.status == 200)
                        this.likeCount -= 1;
                }
            });
            
        }
    }
  };
</script>
