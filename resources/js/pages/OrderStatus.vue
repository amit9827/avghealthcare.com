<template>
    <DefaultLayout>
      <div class="container">
        <p class="p-2">Home / Order #{{ order ? order.id : '...' }}</p>

        <div class="row">
          <div class="col-md-12 mb-5">
            <h3>Order Status</h3>

     <!-- Success -->
        <p v-if="order">
        Status: <strong>{{ order.order_status }}</strong>

        <!-- Payment Failed -->
        <template v-if="order.order_status === 'FAILED'">
            <div class="alert alert-danger mt-3">
            ❌ Your order payment has failed. Please try again.
            </div>
            <a :href="retry_url" class="btn btn-sm btn-warning mt-2">
            🔄 Retry Payment
            </a>
        </template>

        <!-- Payment Pending -->
        <template v-else-if="order.order_status === 'PENDING'">
            <div class="alert alert-warning mt-3">
            ⏳ Your payment is pending. Please wait or recheck the status.
            </div>
            <button @click="verifyPayment" class="btn btn-sm btn-info mt-2">
            🔍 Recheck Status
            </button>
            <br>
            <a :href="retry_url" class="btn btn-sm btn-warning mt-2">
            🔄 Retry Payment
            </a>
        </template>

        <!-- Payment Completed -->
        <template v-else-if="order.order_status === 'COMPLETED'">
            <div class="alert alert-success mt-3">
            ✅ Your order is complete. You will soon receive updates on your registered email.
            </div>
        </template>
        </p>



            <!-- Error -->
            <p v-else-if="error">{{ error }}</p>

            <!-- Loading -->
            <p v-else>Loading...</p>
          </div>
        </div>

        <!-- Accordion for order details -->
        <div v-if="order" class="accordion" id="orderDetailsAccordion">
          <!-- General Information -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingGeneral">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral">
                General Information
              </button>
            </h2>
            <div id="collapseGeneral" class="accordion-collapse collapse show" data-bs-parent="#orderDetailsAccordion">
              <div class="accordion-body">
                <p><strong>Order ID:</strong> {{ order.id }}</p>
                <p><strong>Transaction ID:</strong> {{ order.txn_id }}</p>
                <p><strong>Status:</strong> {{ order.order_status }}</p>
                <p><strong>Total:</strong> {{ order.total_amount }}</p>
                <p><strong>Date:</strong> {{ order.created_at }}</p>
              </div>
            </div>
          </div>

          <!-- Customer Details -->
          <div class="accordion-item" v-if="customer">
            <h2 class="accordion-header" id="headingCustomer">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomer">
                Customer Details
              </button>
            </h2>
            <div id="collapseCustomer" class="accordion-collapse collapse" data-bs-parent="#orderDetailsAccordion">
              <div class="accordion-body">
                <p><strong>Name:</strong> {{ customer.name }}</p>
                <p><strong>Email:</strong> {{ customer.email }}</p>
                <p><strong>Phone:</strong> {{ customer.phone }}</p>
                <p><strong>Address:</strong> {{ customer.address }}</p>
              </div>
            </div>
          </div>

          <!-- Shopping Cart Items -->
          <div class="accordion-item" v-if="shopping_cart_items && shopping_cart_items.length">
            <h2 class="accordion-header" id="headingItems">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseItems">
                Items
              </button>
            </h2>
            <div id="collapseItems" class="accordion-collapse collapse" data-bs-parent="#orderDetailsAccordion">
              <div class="accordion-body">
                <ul>
                  <li v-for="(item, index) in shopping_cart_items" :key="index">
                    {{ item.product.title }} — Qty: {{ item.quantity }} — £{{ item.price }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <p class="mt-5 mb-5">If you need any further assistance with the order, please note down the order id and feel free to contact us.</p>

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
    props: ['txn_id'],

    components: {
      DefaultLayout,
    },

    data() {
      return {
        order: null,
        customer: null,
        shopping_cart_items: [],
        error: null,
        retry_url: null,
        verify_url: null,
      }
    },

    methods: {
      async fetchOrderStatus() {
        try {
          const url = route('order_detail', { txn_id: this.txn_id })
          const res = await axios.get(url)

          // Use backend structure
          this.order = res.data.order
          this.customer = res.data.customer
          this.shopping_cart_items = res.data.shopping_cart_items

          this.retry_url = route('phonepe.createPayment', { order_id: this.order.id})
          this.verify_url = route('phonepe.verifyPayment',  { txn_id: this.txn_id })

          console.log(this.retry_url);

          // Update meta tags once order is loaded
          if (this.order) {
            useHead({
              title: `Order #${this.order.id} | AVG Healthcare`,
              meta: [
                { name: 'description', content: 'Track your order status with AVG Healthcare.' }
              ]
            })
          }
        } catch (err) {
          console.error(err)
          if (err.response && err.response.status === 404) {
            this.error = "Order not found. Please check your transaction ID."
          } else {
            this.error = "Something went wrong. Please try again later."
          }
        }
      },


      async verifyPayment() {
            try {
            // Call backend verifyPayment API
            await axios.get(this.verify_url)

            // Refresh order details after verification
            await this.fetchOrderStatus()
            } catch (err) {
            console.error("Verify payment failed", err)
            this.error = "Could not verify payment at the moment. Please try again later."
            }
        },
    },

    mounted() {
      this.fetchOrderStatus()
    }
  }
  </script>
