<template>
    <span v-if="formatType == 'channel'" class="text-gray-700">{{subscriberCountFormat}} subscribers • {{videoCountFormat}} videos</span>
    <span v-if="formatType == 'video'" class="text-sm text-gray-600">{{subscriberCountFormat}} subscribers</span>
  </template>
  
  <script>
  import numeral from 'numeral';
  export default {
    props: {
        subscriberCount: {
            type: Number,
            required: false,
            default: 0
        },
        videoCount: {
            type: Number,
            required: false,
            default: 0
        },
        formatType: {
            type: String,
            required: false,
            default: 'channel'
        }
    },
    computed: {
        subscriberCountFormat() {
            return numeral(this.subscriberCount).format('0a');
        },
        videoCountFormat() {
            return numeral(this.videoCount).format('0a');
        }
    }
  };
  </script>