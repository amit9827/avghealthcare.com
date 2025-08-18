<template>
        <DefaultLayout>
    <div class="container">
        <p class="p-2">Home / Shopping Cart</p>

        <h1 class="para1_heading m-3">Shopping Cart <a @click="clear"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a></h1>



      <div v-for="item in cartStore.items" :key="item.product.id">

        <div class="row m-2">
            <div class="col-md-2">
                <img :src="getpath(item.product.featured_image)" class="product_img">
            </div>
            <div class="col-md-5">
                {{ item.product.title }}
            </div>
            <div class="col-md-2">
                <span v-if="item.onsale" >₹ <del>{{ item.product.sale_price }}</del> {{ item.product.regular_price }} x {{ item.quantity }}

</span>
                <span v-else >₹ {{ item.product.regular_price }} x {{ item.quantity }}</span>



            </div>
            <div class="col-md-3">
                <button @click="remove(item.product.id)">Remove</button>
            </div>
        </div>


      </div>

    </div>
        </DefaultLayout>
  </template>

  <script>

  import { cartStore, mutations } from '../cartStore'
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import { useHead } from '@vueuse/head'

  export default {

    name: "CartDisplay",
    data() {
      return {
        cartStore,  // reactive store reference
      }
    },

    components : {
        DefaultLayout
    },


    methods: {
      remove(id) {
        mutations.removeFromCart(id)
      },

      clear() {
        mutations.clearCart()
      },

      getpath(product_path) {
      return `..\\images\\${product_path}`;
    },


    }
  }
  </script>

  <style scoped>

  .para1_heading{
    font-size:24px;
    margin:14px;

  }

  .product_img{
    width: 100px;
    height:auto;

  }
  </style>
