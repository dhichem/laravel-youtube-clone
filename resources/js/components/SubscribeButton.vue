<template>
    <button @click="toggleSubscription"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-[#ff302f] hover:bg-[#ff5c5c] rounded-lg focus:ring-4 focus:outline-none no-underline">
                                    {{isSubscribed ? 'Unsubscribe' : 'Subscribe'}}</button>
  </template>
  
  <script>
  export default {
    props: {
        isSubscribed: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        toggleSubscription() {
            if(!window.__auth()) {
                window.location.href = window.location.origin + '/login';
            }
        }
    }
  };
  </script>