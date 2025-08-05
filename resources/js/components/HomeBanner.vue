<template>
    <div class="banner">
      <img :src="src" :alt="alt" class="home_banner" />
    </div>
  </template>

  <script setup>
  defineProps({

    src: {
      type: String,
      required: true
    },

    alt: {
        type: String,
        required: true
    }

  })
  </script>

  <style scoped>
  .home_banner {
    width: 100%;
    height: auto;
    object-fit: cover;
  }
  </style>
