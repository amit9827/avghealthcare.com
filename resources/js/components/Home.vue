<template><h2>Welcome to the Home Page</h2></template>

<script setup>
import { useHead } from '@vueuse/head';

useHead({
  title: 'Home - AvgHealthcare',
  meta: [
    {
      name: 'description',
      content: 'This is the homepage of AvgHealthcare.'
    },
    {
      property: 'og:title',
      content: 'Home - AvgHealthcare'
    }
  ]
});
</script>

