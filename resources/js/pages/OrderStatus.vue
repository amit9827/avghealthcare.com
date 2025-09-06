<template>
    <DefaultLayout>
      <div class="container">
        <p class="p-2">Home / Order #{{ order_id }}</p>

        <div class="row">
          <div class="col-md-12 mb-5">
            <h3>Order Status</h3>
            <p v-if="order">Status: {{ order.order_status }}</p>
            <p v-else>Loading...</p>
          </div>
        </div>
      </div>
    </DefaultLayout>
  </template>

  <script>
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import { useHead } from '@vueuse/head'
  import axios from 'axios'
  import { route } from 'ziggy-js'

  export default {
    name: "OrderStatus",
    props: ['order_id'],

    components: {
      DefaultLayout,
    },

    data() {
      return {
        order: null,
      }
    },

    created() {
      useHead({
        title: `Order #${this.order_id} | AVG Healthcare`,
        meta: [
          { name: 'description', content: 'Track your order status with AVG Healthcare.' }
        ]
      })
    },

    methods: {
      async fetchOrderStatus() {
        try {
          const url = route('order_detail', { id: this.order_id }) // 👈 adjust route name
          const res = await axios.get(url)
          this.order = res.data
        } catch (err) {
          console.error(err)
        }
      }
    },

    mounted() {
      this.fetchOrderStatus()
    }
  }
  </script>
