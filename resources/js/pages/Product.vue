<template>
    <DefaultLayout>
        <div class="container">

        <!-- Loading state -->
        <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
      <div class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-else>


            <p class="p-2">
                <RouterLink class="nav-link inline" :to="{ name: 'Home' }">Home</RouterLink> / {{ product.title }}</p>


            <div class="row m-3">
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-6 product_img_frame">

                            <Lightbox :src="getpath(product.featured_image)" alt="Product Image" imgClass="product_img" />

                        </div>

                        <template v-for="(image, index) in additional_product_images"
                        :key="index"
                        >
                        <div class="col-md-6 product_img_frame">
                         <Lightbox :src="getpath(image.path)" alt="Product Image"  />

                        </div>

                        </template>


                    </div>
                </div>

                <div class="col-md-6">
                    <h1 class="para1_heading mt-3">{{ product.title }}</h1>
                    <h2 class="fs-6 fs-md-5 fw-normal text-dark lh-sm line-clamp-3">


<template  v-if="product.benefits_tags">
                          <span

            v-for="(sub, index) in product.benefits_tags.split(',')"
            :key="index"
            class="badge rounded-pill text-dark px-2 py-1 me-1 mb-2"
             :style="{
                backgroundColor: getRandomColor(index),
                fontSize: '0.875rem',
                fontWeight: 400,
                textTransform: 'capitalize'
            }"

          > {{ sub.trim() }}
          </span>
        </template>


                    </h2>
                    <a href="#product-reviews" class="d-inline-flex align-items-center gap-1 text-decoration-none">
                        <div class="d-inline-flex align-items-center gap-1">
                            <i class="fas fa-star color-custom-orange"></i>
                            <p class="mb-0 small fw-normal text-dark text-capitalize">{{ product.average_rating }}</p>
                        </div>
                        <p class="mb-0 small fw-normal text-dark text-capitalize">({{product.rating_count}}) reviews</p>
                    </a>


                    <div class="mb-3 my-2 flex flex-col gap-y-1 flex">{{ product.description }}</div>

                    <div>


                        <div class="accordion" id="myAccordion">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        0 Offer Available
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#myAccordion">
      <div class="accordion-body row">
        <div class="col-md-10">
        Keep visiting this section for latest offer.
        </div>
        <div class="col-md-2">

        <div class="d-flex flex-column align-items-end gap-1">
  <span class="small fw-light text-dark min_50px">Use code</span>
  <span class="small fw-normal text-dark border border-dark border-dashed rounded-pill bg-white px-2 py-1 min_50px text-center">
    ----
  </span>
</div>
</div>



      </div>
    </div>
  </div>
</div>


<div class="mt-3">



<div class="text-center  ">

    <div class="row m-1 mb-3 p-3" id="product_price">
        <label class="col-md-6 text-start">Price Per Unit</label>
        <div class="p1_heading  col-md-6 text-end" v-if="product.onsale" ><del class="text-gray-light"> ₹{{ product.regular_price}}</del> ₹{{ product.sale_price}}</div>
        <div class="p1_heading  col-md-6 text-end" v-else >₹{{ product.regular_price}}</div>
    </div>

<button
type="button"
class="btn  btn-custom w-100 btn-warning text-white rounded-pill fw-medium  py-3 d-flex justify-content-center align-items-center gap-2 button_text"
style="min-width: 4.5rem; width: 2rem;"
aria-label="Add Button" @click="add(product)"
v-if="!getQuantity(product)"
>
Add To Cart
</button>

<div class="row text-center" v-if="getQuantity(product)">
    <div class="col-md-6">
        <div class="product_quantity text-center "   >
            <div class="quantity-grid border rounded overflow-hidden m-auto mb-3">
                <button type="button"  @click="decrement(product)" class="btn quantity-btn">-</button>
                <span class="quantity-value">{{ getQuantity(product) }}</span>
                <button type="button"  @click="increment(product)" class="btn quantity-btn">+</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
    <RouterLink to="/cart"
    class="btn  btn-custom w-100 btn-warning text-white rounded-pill fw-medium  py-3 d-flex justify-content-center align-items-center gap-2 button_text"
    >GO TO CART</RouterLink>
    </div>
</div>


</div>




</div>

<div class="m-3 d-flex justify-content-evenly gap-2 flex-wrap">
  <!-- Ships within 1-2 days -->
  <div class="d-flex align-items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 80 80" fill="currentColor">
      <g transform="translate(0,80) scale(0.1,-0.1)">
        <path d="M120 590 c0 -6 67 -10 188 -10 115 0 192 -4 198 -10 7 -7 4 -48 -9 -130 -18 -108 -18 -145 -1 -128 3 4 13 52 22 108 l16 101 66 -3 65 -3 27 -50 c24 -42 28 -60 25 -115 -2 -53 -5 -65 -20 -68 -10 -2 -29 8 -42 22 -32 34 -77 35 -103 1 -19 -24 -24 -25 -132 -25 -107 0 -114 1 -136 25 -15 16 -34 25 -53 25 -29 0 -61 -22 -61 -41 0 -5 -11 -9 -25 -9 -16 0 -25 -6 -25 -15 0 -9 9 -15 25 -15 14 0 25 -4 25 -9 0 -19 32 -41 61 -41 19 0 38 9 53 25 22 24 28 25 140 25 65 0 116 -4 116 -9 0 -20 33 -41 65 -41 26 0 39 6 51 25 9 14 25 25 35 25 66 0 81 117 29 220 -35 70 -51 80 -122 80 -46 0 -55 3 -63 23 -10 22 -13 22 -212 25 -133 1 -203 -1 -203 -8z m140 -294 c16 -20 9 -56 -12 -70 -40 -24 -80 44 -42 71 23 17 39 16 54 -1z m377 -12 c12 -19 11 -24 -6 -45 -16 -21 -22 -22 -45 -11 -31 14 -36 55 -8 71 24 15 42 10 59 -15z"></path>
      </g>
    </svg>
    <p class="mb-0 small text-dark">Ships within 1-2 days</p>
  </div>

  <!-- Shipping Across India -->
  <div class="d-flex align-items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 65" fill="currentColor">
      <g transform="translate(0,65) scale(0.1,-0.1)">
        <path d="M132 624 c-16 -7 -6 -72 15 -96 13 -14 12 -20 -1 -45 -26 -47 -43 -64 -59 -57 -20 7 -32 -29 -18 -55 15 -28 14 -30 -14 -41 -25 -10 -25 -10 -8 -37 23 -36 34 -44 56 -39 10 3 17 -2 17 -11 0 -8 19 -66 42 -129 33 -91 45 -114 61 -114 30 0 56 40 57 87 0 37 6 47 52 90 28 26 61 57 72 68 12 11 26 20 31 20 6 0 9 19 7 43 -2 23 0 42 5 42 15 0 34 -17 31 -26 -2 -5 7 -20 20 -34 l23 -25 6 23 c3 12 9 22 13 22 5 0 11 14 15 31 4 18 15 33 25 36 25 7 32 30 17 53 -17 28 -54 25 -95 -7 -30 -23 -37 -24 -55 -13 -17 10 -22 10 -32 -4 -11 -14 -18 -13 -73 10 -40 18 -59 31 -55 40 3 7 -2 21 -11 29 -19 19 -20 45 -4 80 14 31 9 36 -44 46 -24 4 -52 10 -63 13 -11 2 -26 2 -33 0z"></path>
      </g>
    </svg>
    <p class="mb-0 small text-dark">Shipping Across India</p>
  </div>
</div>




<div class="row"  >
    <div class="col-md-12">
  <img
    src="/public/assets/payment_mode.webp"

    alt="payment mode"
    class="payment_gateways"
    loading="lazy"
    decoding="async"
  >
    </div>
</div>


<!-- Benefits -->
<div class="accordion mt-3" id="myAccordion">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
       Benefits
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#myAccordion">
      <div class="accordion-body row">
        <div class="col-md-12">
            {{ product.benefits }}
        </div>




      </div>
    </div>
  </div>
</div>



                    </div>





                </div>

            </div>




<div class="row" id="benefits_block">

  <div class="cl-md-12 text-center"><h3 class="para3_heading">Benefits</h3></div>



  <div
    v-for="(benefit, index) in benefits"
    :key="index"
    class="col-md-3"
  >

  <div class="d-flex flex-column align-items-center w-100">

    <!-- Image -->
    <img
      :src="getpath(benefit.image_path)"
      :alt="benefit.name"
      class="img-fluid mb-2"
      width="100"
      height="96"
      loading="lazy"
      decoding="async"
      style="max-width: 92px;"
    />

    <!-- Name + Description -->
    <div class="d-flex flex-column align-items-center justify-content-center gap-1">
      <h5
        class="text-center fw-medium text-capitalize mb-1"
        style="line-height: 1.2;"
      >
        {{ benefit.name }}
      </h5>
      <p class="text-center small mb-0" style="line-height: 1.4;">
        {{ benefit.description }}
      </p>
    </div>
  </div>
</div>




</div>

<div class="row">
  <div id="product_banner">
    <div class="col-md-12">


                        <img
                        v-if="product.banner_image && product.banner_image !== ''"
                        :src="getpath(product.banner_image)"
                        class="h-auto w-full object-contain"
                        alt="Product Highlight 1"
                        fetchpriority="high"
                        width="500"
                        height="500"
                        decoding="async"
                        data-nimg="1"
                        style="color: transparent;"
                        >









    </div>
  </div>
</div>


<div class="row">
  <div id="product_banner">
    <div class="col-md-12">

        <template v-for="(image, index) in additional_banner_images"
                        :key="index"
                        >

                        <img :src="getpath(image.path)"
                        class="h-auto w-full object-contain"
                        alt="Product Highlight 1"
                        fetchpriority="high"
                        width="500"
                        height="500"
                        decoding="async"
                        data-nimg="1"
                        style="color: transparent;"
                        >




                        </template>




    </div>
  </div>
</div>







<!-- ratings -->
<ProductReview />

        <!-- review card closed-->


        <!--  product description -->

<div class="accordion mt-3 mb-5" id="myAccordion">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
       Product Details
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#myAccordion">
      <div class="accordion-body row">
        <div class="col-md-12">
            <div v-html="product.long_description"></div>
     </div>




      </div>
    </div>
  </div>
</div>

</div>
        <!-- product description ends-->
    </div>
    <FloatingCart :itemCount="3" :total="1147" :show="true" />
    </DefaultLayout>
  </template>
<script>
import DefaultLayout from '../layouts/DefaultLayout.vue'
import { useHead } from '@vueuse/head'
import ProductReview from '../components/ProductReviews.vue'
import FloatingCart from '../components/FloatingCart.vue'
import axios from 'axios'
import { route } from 'ziggy-js'
import { mutations, getters } from '../cartStore'
import Lightbox from '../components/Lightbox.vue'

export default {
  name: 'Product',
  components: {
    DefaultLayout,
    ProductReview,
    FloatingCart,
    Lightbox,
  },
  data() {
    return {
        loading:true,
      subcategories: [],
      category: [],
      subcategory: '',
      product: [],
      additional_product_images: [],
      additional_banner_images: [],
      benefits:[],
      colors: [
        "rgb(203, 237, 243)", // light blue
        "rgb(255, 230, 230)", // light red
        "rgb(230, 255, 230)", // light green
        "rgb(255, 245, 204)", // light yellow
        "rgb(230, 230, 255)", // light purple
        "rgb(255, 240, 245)"  // light pink
      ],
    }
  },


  created() {
    this.updateHead(this.$route.params.slug)
    this.fetchProduct(this.$route.params.slug)
  },
  watch: {
    '$route.params.slug': {
      immediate: true,
      handler(newSlug) {
        this.fetchProduct(newSlug)
        this.updateHead(newSlug)
      }
    }
  },
  methods: {
    async fetchProduct(slug) {
      try {
        const url = route('product_by_slug', { product_slug: slug });
        const res = await axios.get(url);
        this.category = res.data.category;
        this.subcategories = res.data.subcategories;
        this.product = res.data.product;
        this.benefits = res.data.benefits;

        this.additional_product_images = res.data.additional_product_images;
        this.additional_banner_images = res.data.additional_banner_images;
        this.loading = false;

            // ✅ Now update the head with fresh product meta
    this.updateHead();


      } catch (err) {
        console.error(err);
      }
    },
    updateHead() {
  if (!this.product) return;

  useHead({
    title: `${this.product.meta_title || this.product.title} | AVG Healthcare`,
    meta: [
      {
        name: 'description',
        content: this.product.meta_description || this.product.short_description || 'Product page of AVG Healthcare.'
      },
      {
        name: 'keywords',
        content: this.product.meta_keywords || this.product.title || 'Product page of AVG Healthcare.'
      },
      {
        property: 'og:title',
        content: `${this.product.meta_title || this.product.title} | AVG Healthcare`
      },
      {
        property: 'og:description',
        content: this.product.meta_description || this.product.short_description || 'Product page of AVG Healthcare.'
      },
      {
        property: 'og:image',
        content: this.getpath(this.product.featured_image) ? this.getpath(this.product.featured_image) : '/default-image.jpg'
      },
      {
        property: 'og:url',
        content: window.location.href
      },

    ]
  })
},

    getpath(product_path) {
      return `..\\images\\${product_path}`;
    },
    getRandomColor(index) {
      return this.colors[index % this.colors.length];
    },

    add(product) {
      mutations.addToCart(product)
    },
    increment(product) {
      mutations.incrementQuantity(product)
    },

    decrement(product) {
      mutations.decrementQuantity(product)
    },

    getQuantity(product) {
      return getters.getProductQuantity(product.id)
    },

    getPrice(product) {
    if(product.onsale)
      return getters.getProductQuantity(product.id)
    },





  }
}
</script>


<script setup>

import { useHead } from '@vueuse/head'

useHead({
  title: 'Product | AVG Healthcare',
  meta: [
    { name: 'description', content: 'Product from AVG Healthcare.' }
  ]
})
</script>


  <style scoped>

  .product_img_frame{
    padding:10px;
  }

  .product_img{
    max-width:100%;
    height:auto;
    width:auto;

    border-radius:10px;
    display: block;
  }

  .para1_heading{
    font-weight:bold;
    font-size:28px;
  }

  .line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.button_text{
    font-size:18px;
}

.btn-custom {
    background-color: rgba(221, 132, 52, 1); /* equivalent to rgb(221 132 52) */
    color: #fff; /* white text */
    border-radius: 50px; /* rounded-full */
    font-weight: 500; /* medium */
    padding: 0.75rem 1.5rem; /* py-3 and px approx */
    transition: background-color 0.2s;
}

.btn-custom:hover {
    background-color: rgba(200, 120, 40, 1); /* slightly darker on hover */
}

.payment_gateways{
    width:100%;
    height:auto;
    margin:0;
}

#benefits_block{
  margin:50px 0px;
  background-color:rgb(247 247 231);
  padding:20px;
}

#product_banner {
  padding: 0 10%;

}
#product_banner img{
  width:100%;
  margin-bottom:50px;

}

.color-custom-orange{
color:#ffbb38;
}

.bg-custom-orange-dark{
background-color: #ed7f30;
}


.product-card {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 15px;
  border-radius: 0.5rem;
  background-color: white;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  text-decoration: none;
  color: inherit;

  margin:10px auto;
}

.product-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.quantity-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  width: 14.5rem;
  height: 64.5px;
}

.quantity-btn {
  background-color: #f3fbd1;
  color: #000;
  line-height: 1;
  border: none;
  border-radius: 0;
  display: flex !important;
  align-items: center;
  justify-content: center;
  font-weight: 500; /* fw-medium */
  text-transform: capitalize;
  padding: 0;
  font-size: 1rem;
}

.quantity-value {
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 400; /* fw-normal */
  color: #6c757d; /* Bootstrap's text-secondary */
  font-size: 0.875rem;
  user-select: none;
}

.text-gray-light{
    color:#999;
}

#product_price {

    font-size:18px;
    font-weight: bold;
    border: 1px solid #ed7f30;
    background: #fbebdf;
    border-radius: 10px;

}

.min_50px{
    min-width:50px;
}


  </style>
