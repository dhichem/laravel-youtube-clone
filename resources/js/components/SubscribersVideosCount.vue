<template>
    <span class="text-gray-700">{{subscriberCountFormat}} subscribers • {{videoCountFormat}} videos</span>
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