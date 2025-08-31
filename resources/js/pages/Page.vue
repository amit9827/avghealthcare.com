<template>
    <DefaultLayout>
      <div class="container">
        <p class="p-2">Home / {{ page.title }}</p>
        <HomeBanner

        :src="getpath(page.featured_image)"
          alt="Image1" />


        <div class="row">


            <div class="col-md-12 mb-5">
                <div v-html="page.long_description"></div>
                </div>



</div>
</div>

<div class="row">




    <div class="col-md-12">

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
      <FloatingCart :itemCount="3" :total="1147" :show="true" />
    </DefaultLayout>
  </template>

  <script>
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import HomeBanner from '../components/HomeBanner.vue'
  import Products from '../components/Products.vue'
  import FloatingCart from '../components/FloatingCart.vue'

  import { useHead } from '@vueuse/head'
  import axios from 'axios'
  import { route } from 'ziggy-js'


  export default {
    name: "Page",
    props: ['slug'],

    components: {
      HomeBanner,
      DefaultLayout,
      Products,
      FloatingCart
    },

    data() {
      return {
        subcategories: [],
        category:[],
        subcategory:'',
        page:[],

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


    watch: {
  slug: {
    immediate: true,
    handler(newSlug) {
      this.fetchCategory(newSlug);
    }
  }
},
methods: {
  async fetchCategory(slug) {
    try {
      const url = route('page_by_slug', { page_slug: slug });
      const res = await axios.get(url);

      this.page = res.data.page;
      console.log(this.products);
    } catch (err) {
      console.error(err);
    }
  },


  getpath(image_path) {
      return `..\\images\\${image_path}`;
    },

},



    mounted() {


        this.fetchCategory(this.slug);

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
