<template>
    <DefaultLayout>
      <h2 class="text-xl font-bold mb-4">Welcome to AVG Healthcare</h2>
      <p>This is the Home Page content.</p>
    </DefaultLayout>
  </template>

  <script setup>
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import { useHead } from '@vueuse/head'

  useHead({
    title: 'Home | AVG Healthcare',
    meta: [
      { name: 'description', content: 'Welcome to the Home Page of AVG Healthcare.' }
    ]
  })
  </script>
