<template>
    <DefaultLayout>


     <div class="container">
        <div v-if="category_featured.length" class="row mb-5">
        <div v-for="category in category_featured" :key="category.id" class="col-md-12 col-12 product">

   <RouterLink
  :to="{ name: 'Category', params: { slug: category.slug } }"
  class="d-flex flex-column justify-content-start gap-2 gap-md-3 align-self-stretch rounded p-1 p-md-0 bg-white h-auto text-decoration-none text-black"
>
 <HomeBanner  :src="getpath(category.image_path)"  alt="category.title" />

   </RouterLink>
        </div>
    </div>

     </div>
     <FloatingCart :itemCount="3" :total="1147" :show="true" />
    </DefaultLayout>
  </template>

  <script >
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import HomeBanner from '../components/HomeBanner.vue'
  import FloatingCart from '../components/FloatingCart.vue'
  import { useHead } from '@vueuse/head'

  import { RouterLink } from 'vue-router'
import axios from 'axios'
import { route } from 'ziggy-js'


  export default{
    name : "Home",
    components : {
        HomeBanner,DefaultLayout,FloatingCart
    },


    data() {
      return {
        category_featured: [],


      }
    },


    async mounted() {
    try {
      const response = await axios.get(route('category_featured'))

      this.category_featured = response.data.category_featured || []


      console.log( this.category_featured);

    } catch (error) {
      console.error('Menu fetch failed:', error)
    }
  },


methods: {
    getpath(product_path) {
        product_path = "..\\images\\" + product_path;
        return product_path;
    },

    getUrl(slug) {
        slug = "..\\product\\" + slug;
        return slug;
    },



  },
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
