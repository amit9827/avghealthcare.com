<template>
        <DefaultLayout>
    <div>
      <div v-for="item in cartStore.items" :key="item.product.id">
        {{ item.product.title }} x {{ item.quantity }}
        <button @click="remove(item.product.id)">Remove</button>
      </div>
      <button @click="clear">Clear Cart</button>
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
      }
    }
  }
  </script>
