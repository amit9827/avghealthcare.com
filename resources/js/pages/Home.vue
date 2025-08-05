<template>
    <DefaultLayout>


     <div class="container">
        <HomeBanner src="\banners\banner1.jpg" alt="Image1" />
        <HomeBanner src="\banners\banner2.jpg" alt="Image1" />

        <HomeBanner src="\banners\banner4.jpg" alt="Image1" />
        <HomeBanner src="\banners\banner3.jpg" alt="Image1" />
     </div>

    </DefaultLayout>
  </template>

  <script >
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import HomeBanner from '../components/HomeBanner.vue'
  import { useHead } from '@vueuse/head'

  export default{
    name : "Home",
    components : {
        HomeBanner,DefaultLayout
    }

  }

  useHead({
    title: 'Home | AVG Healthcare',
    meta: [
      { name: 'description', content: 'Welcome to the Home Page of AVG Healthcare.' }
    ]
  })
  </script>

  <style >



  </style>
