<template>
    <DefaultLayout>
      <div class="container">
        <p class="p-2">Home / {{ category.title }}</p>
        <HomeBanner src="/banners/banner1.jpg" alt="Image1" />


        <div class="row">
            <div class="col-md-2"><h1 class="para1_title">{{ category.title }}</h1></div>
            <div class="col-md-10">

        <div v-if="subcategories.length">
            <ul class="nav nav-pills gap-2 flex-nowrap" role="tablist">

                <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill border px-3 py-1 text-capitalize" id="tab-all" data-bs-toggle="tab" data-bs-target="#panel-all" type="button" role="tab">All</button>
                </li>

                <div v-for="subcategory in subcategories" :key="subcategory.id">
                <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill border px-3 py-1 text-capitalize" id="tab-all" data-bs-toggle="tab" data-bs-target="#panel-all" type="button" role="tab">{{ subcategory.title }}</button>
                </li>
                </div>

            </ul>
        </div>




</div>
</div>

<div class="row">

    <div class="col-md-12 text-end">
    <label for="sorty_by">Sort By </label>
    <select name="sort_by" id="sort_by">
        <option value="">Sort by</option>
    </select>
</div>
    <div class="rol-md-12">

          <!-- Passing props to Products component -->
          <Products

          :products = "products"

         />
    </div>
</div>


      </div>
    </DefaultLayout>
  </template>

  <script>
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import HomeBanner from '../components/HomeBanner.vue'
  import Products from '../components/Products.vue'

  import { useHead } from '@vueuse/head'
  import axios from 'axios'
  import { route } from 'ziggy-js'


  export default {
    name: "Category",
    props: ['slug'],

    components: {
      HomeBanner,
      DefaultLayout,
      Products
    },

    data() {
      return {
        subcategories: [],
        category:[],
        subcategory:'',
        products:[],

      }
    },

    created() {

        useHead({
        title: this.slug + ` | AVG Healthcare`,
        meta: [
          { name: 'description', content: 'Welcome to the Home Page of AVG Healthcare.' }
        ]
      })
    },
    mounted() {


      const url =  route('category', { category_slug: this.slug})


      axios.get(url)
        .then(res => {
          this.subcategories = res.data.subcategories
          this.category = res.data.category
          this.products = res.data.products
          console.log( this.products )

        })
    }
  }
  </script>

  <style>
  /* your styles here */

  .nav-pills .nav-link {
  border-color: #d9f99d; /* lime-100-like color */
  font-weight: 300;
  font-size: 0.9rem;
}

.nav-pills .nav-link.active {
  background-color: #eff6ff; /* blue-50-like color */
  border-color: #eff6ff;
  font-weight: 500;
}

.para1_title{
    font-size:18px;
}

#sort_by{
    margin : 10px 20px;
}

  </style>
