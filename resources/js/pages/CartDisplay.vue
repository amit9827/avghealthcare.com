<template>
        <DefaultLayout>
    <div class="container">
        <p class="p-2">Home / Shopping Cart</p>
        <div class="row">
<div class="col-md-8">
        <div class="card mb-5">

        <div class="card-header">
        <h1 class="para1_heading m-3">Shopping Cart - ref {{  cartStore.session_id  }}
            <a @click="clear"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
        </h1>
        </div>

        <div class="card-body">



      <div v-for="item in cartStore.items" :key="item.product.id" class="m-4">

        <div class="row">
            <div class="col-md-2">
                <RouterLink
  :to="{ name: 'Product', params: { slug: item.product.slug } }"
  class="d-flex flex-column justify-content-start gap-2 gap-md-3 align-self-stretch rounded p-1 p-md-0 bg-white h-auto text-decoration-none text-black"
>

                <img :src="getpath(item.product.featured_image)" class="product_img">
                </RouterLink>
            </div>
            <div class="col-md-5">
                {{ item.product.title }}
            </div>
            <div class="col-md-2">
                <span v-if="item.product.onsale" >₹ <del>{{ item.product.regular_price }}</del> {{ item.product.sale_price }} x {{ item.quantity }}

</span>
                <span v-else >₹ {{ item.product.regular_price }} x {{ item.quantity }}</span>



            </div>
            <div class="col-md-3">
                <button @click="remove(item.product.id)">Remove </button>
            </div>


        </div>

      </div>
    </div>


        <div class="card-footer">
            <div class="row text-start">
            <div class="col-md-2">  </div>
            <div class="col-md-5">Items: {{ itemCount }}
            </div>
            <div class="col-md-2">Subtotal: ₹{{ cartTotal }} </div>
            <div class="col-md-3"></div>

        </div>
        </div>


    </div>
</div>
<div class="col-md-4">
    <div class="card mb-5">

<div class="card-header">
<h1 class="para1_heading m-3">Cart totals</h1>
</div>

<div class="card-body">

    <table cellspacing="0" class="table table-striped">

<tbody><tr class="cart-subtotal">
    <th>Subtotal</th>
    <td data-title="Subtotal" class="text-end"> <span class="woocommerce-Price-currencySymbol">₹</span>{{ cartTotal }}</td>
</tr>



            <tr class="fee">
        <th>Shipping Fee</th>
        <td data-title="Shipping Fee" class="text-end"> <span class="woocommerce-Price-currencySymbol">₹</span>{{ shippingFee }} </td>
    </tr>



    <tr class="fee">
        <th>Payment Method</th>
        <td data-title="COD Fee" class="text-end">
        <select name="fee" v-model="payment_fee" >
            <option value="0">Online </option>
            <option :value="CODFee">Cash on Delivery : <span class="woocommerce-Price-currencySymbol">₹</span>{{ CODFee }} </option>
        </select>

        </td>
    </tr>



<tr class="order-total">
    <th>Total</th>
    <td data-title="Total" class="text-end"><strong> <span class="woocommerce-Price-currencySymbol">₹</span>{{ gTotal }} </strong> </td>
</tr>


</tbody></table>
</div>
</div>
</div>
</div>

    <div class="card mb-3">
       <div class="card-header">
        Billing Address
       </div>

       <div class="card-body">
        <input type="text" name ="name"   v-model="cartStore.address.name"  placeholder="Name" class="form-control">
        <input type="text" name="address"  v-model="cartStore.address.address"   placeholder="Address" class="form-control">
        <input type="text" name="town"  v-model="cartStore.address.town"  placeholder="Town" class="form-control">
        <input type="text" name="pin_code"  v-model="cartStore.address.pin_code"  placeholder="PIN" class="form-control">
        <input type="text" name="state"  v-model="cartStore.address.state"  placeholder="State" class="form-control">
        <input type="text" name="phone"  v-model="cartStore.address.phone"  placeholder="Phone" class="form-control">
        <input type="text" name="email"  v-model="cartStore.address.email"  placeholder="Email" class="form-control">
        <input type="hidden" name="session_id"  v-model="cartStore.session_id"  placeholder="session_id" class="form-control">


       </div>
    </div>

    <div class="card mb-3">
       <div class="card-header">
        Shipping Address         <button type="button" style="float:right" @click="copybilling" >Copy from Billing</button>

       </div>

       <div class="card-body">

        <input type="text" name ="name"   v-model="cartStore.shipping_address.name"  placeholder="Name" class="form-control">
        <input type="text" name="address"  v-model="cartStore.shipping_address.address"   placeholder="Address" class="form-control">
        <input type="text" name="town"  v-model="cartStore.shipping_address.town"  placeholder="Town" class="form-control">
        <input type="text" name="pin_code"  v-model="cartStore.shipping_address.pin_code"  placeholder="PIN" class="form-control">
        <input type="text" name="state"  v-model="cartStore.shipping_address.state"  placeholder="State" class="form-control">
        <input type="text" name="phone"  v-model="cartStore.shipping_address.phone"  placeholder="Phone" class="form-control">
        <input type="text" name="email"  v-model="cartStore.shipping_address.email"  placeholder="Email" class="form-control">


       </div>
    </div>
    <button @click="submitCart" class="btn btn-primary m-3">Submit Order</button>


    </div>
        </DefaultLayout>
  </template>

  <script>

  import { cartStore, mutations } from '../cartStore'
  import DefaultLayout from '../layouts/DefaultLayout.vue'
  import { useHead } from '@vueuse/head'
  import axios from 'axios'
  import { route } from 'ziggy-js'

  export default {

    name: "CartDisplay",
    data() {
      return {
        cartStore,  // reactive store reference
        copyshipping_option:0,
        min_order_amount:0,
        CODFee:60,
        payment_fee:0,

      }
    },

    components : {
        DefaultLayout
    },


    computed: {

        // compute item count reactively
        itemCount() {
        return this.cartStore.items.reduce((acc, item) => acc + item.quantity, 0);
        },

        // compute total reactively
        cartTotal() {
        return this.cartStore.items.reduce((acc, item) => {
                let price = Number(item.product.regular_price) || 0;
                if (item.product.onsale) {
                price = Number(item.product.sale_price) || price;
                }
                let quantity = Number(item.quantity) || 0;
                return acc + (price * quantity);
            }, 0);
            },

            shippingFee(){

            if(this.cartTotal <= 0 ) return 0;
            if(this.cartTotal < this.min_order_amount)
            return 60;

            return 0;
            },

            gTotal(){

                if(this.cartTotal >0)
                return this.cartTotal + this.shippingFee + this.payment_fee;

                return 0;
            }


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

    async submitCart() {
      try {

        const response = await axios.post(route('checkout'), {

          session_id: this.cartStore.session_id,
          address: this.cartStore.address,
          shipping_address: this.cartStore.shipping_address,
          items: this.cartStore.items,
          total_amount: this.cartTotal,

        })

        console.log("Cart submitted:", response.data.order_id);
        if(response.data.order_saved ==1 )
        location.href=route('phonepe.createPayment', [response.data.order_id]);

        alert("Order submitted successfully!")

      } catch (error) {

        console.error("Error submitting cart:", error)
        alert("Something went wrong. Please try again.")

      }
    },

    copybilling(){


        this.cartStore.shipping_address = this.cartStore.address;

    },
    async fetchMinOrder() {
    try {
      const url = route('min_order_amount');
      const res = await axios.get(url);
      this.min_order_amount = res.data.min_order_amount;

      console.log(this.min_order_amount);
    } catch (err) {
      console.error(err);
    }
  }


    },
    mounted() {
this.fetchMinOrder();

    },


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
