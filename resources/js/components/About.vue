<template><h2>Welcome to the About Page</h2></template>
<script setup>
import { useHead } from '@vueuse/head';

useHead({
  title: 'About - AvgHealthcare',
  meta: [
    {
      name: 'description',
      content: 'This is the about of AvgHealthcare.'
    },
    {
      property: 'og:title',
      content: 'Home - AvgHealthcare'
    }
  ]
});
</script>
