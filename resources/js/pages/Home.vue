<template>
    <DefaultLayout>


     <div class="container">

        <p v-if="$route.query.message === 'page-not-found'" class="text-danger p-2 bg-custom">
      Page not found. Redirected to Home.
    </p>



           <!-- Loading state -->
    <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
      <div class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-else>


        <div v-if="category_featured.length" class="row mb-5">
        <div v-for="category in category_featured" :key="category.id" class="col-md-12 col-12 product">

   <RouterLink
  :to="{ name: 'Category', params: { slug: category.slug } }"
  class="d-flex flex-column justify-content-start gap-2 gap-md-3 align-self-stretch rounded p-1 p-md-0 bg-white h-auto text-decoration-none text-black"
>
 <HomeBanner  :src="getpath(category.image_path)"  :alt="category.name" />

   </RouterLink>
        </div>
    </div>
    <div v-else> No Category Banners Found</div>
    </div>


    <div v-if="brand_featured.length" class="mb-5 row">
        <hr/>
        <h1 class="text-center pt-3 pb-3 color-green">Our Packages</h1>
        <div v-for="category in brand_featured" :key="category.id"   class="col-md-3">

   <RouterLink
  :to="{ name: 'Category', params: { slug: category.slug } }"

>
 <Packages  :src="getpath(category.brand_image_path)"  :alt="category.name" />

   </RouterLink>
</div>
    </div>
    <div v-else></div>







<div v-if="products.length" class="rol-md-12">
        <hr/>
        <h1 class="text-center pt-3 pb-3 color-green">Our Best Sellers</h1>

<!-- Passing props to Products component -->
<Products

:products = "products"

/>
</div>




     </div>
     <FloatingCart :itemCount="3" :total="1147" :show="true" />
    </DefaultLayout>
  </template>

  <script >
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import HomeBanner from '../components/HomeBanner.vue'
  import FloatingCart from '../components/FloatingCart.vue'
  import Products from '../components/Products.vue'
  import Packages from '../components/Packages.vue'


  import { RouterLink } from 'vue-router'
  import axios from 'axios'
  import { route } from 'ziggy-js'


  export default{
    name : "Home",
    components : {
        HomeBanner,DefaultLayout,FloatingCart,Products, Packages,
    },


    data() {
      return {
        loading: true,  // start as loading
        category_featured: [],
        slug:"cardio-care",
        products:[],
        brand_featured:[],


      }
    },


    async mounted() {
    try {
      const response = await axios.get(route('category_featured'))

      this.category_featured = response.data.category_featured || [];
      this.brand_featured = response.data.brand_featured || [];

      console.log(response);

      this.loading=false;  // start as loading




    } catch (error) {
      console.error('Menu fetch failed:', error)
    }

     try {
      const url = route('products_featured');
      const res = await axios.get(url);

      this.products = res.data.products_featured;

    } catch (err) {
      console.error(err);
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





  </script>

<script setup>
import { useHead } from '@vueuse/head'

useHead({
  title: 'Home | AVG Healthcare',
  meta: [
    { name: 'description', content: 'Welcome to the Home Page of AVG Healthcare.' }
  ]
})
</script>


  <style >
.product{
    margin-bottom:20px;
}

.bg-custom{
    background-color:antiquewhite;
    margin-top:20px;
}


  </style>
