<template>
    <DefaultLayout>
      <h2 class="text-xl font-bold mb-4">About Us</h2>
      <p>This is the About Page content.</p>
    </DefaultLayout>
  </template>

  <script setup>
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import { useHead } from '@vueuse/head'

  useHead({
    title: 'About | AVG Healthcare',
    meta: [
      { name: 'description', content: 'Learn more about AVG Healthcare.' }
    ]
  })
  </script>
