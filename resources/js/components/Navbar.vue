<template>
    <nav class="bg-blue-700 text-white p-4 flex gap-6">
      <RouterLink to="/" class="hover:underline">Home</RouterLink>
      <RouterLink to="/about" class="hover:underline">About</RouterLink>
    </nav>
  </template>

  <script setup>
  import { RouterLink } from 'vue-router'
  </script>

  <style scoped>
  nav {
    font-weight: bold;
  }
  </style>
