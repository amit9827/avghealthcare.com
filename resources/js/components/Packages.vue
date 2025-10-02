<template>

      <img :src="src" :alt="alt" class="package_banner" />

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
  .package_banner {
    width: 100%;
    height: auto;
    object-fit: cover;
  }
  </style>
