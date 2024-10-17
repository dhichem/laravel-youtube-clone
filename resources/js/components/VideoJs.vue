<template>
    <video-player
        preload="auto"
        :src="videoSource"
        type="application/x-mpegURL"
        controls
    />
</template>

<script>
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
export default {
    components: {
        VideoPlayer
    },
    props: {
        videoSource: {
            type: String,
            required: false,
        },
    },
};
</script>
