<template>
        <DefaultLayout>
    <div class="container">
        <p class="p-2"><RouterLink class="nav-link inline" :to="{ name: 'Home' }">Home</RouterLink>  / Shopping Cart</p>
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
  <th>Payment </th>
  <td data-title="COD Fee" class="text-end">
    <select name="payment_method" v-model="payment_method" @change="setPaymentFee" class="form-control">
      <option value="PhonePe">Online - PhonePe</option>
      <option value="COD">Cash on Delivery + ₹{{ CODFee }}</option>
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


  <!-- 🔴 Show error here -->
  <div v-if="errorMessage" class="alert alert-danger m-3">
    {{ errorMessage }}
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
        payment_method:"PhonePe",
        errorMessage: "",   // 🔴 for showing validation errors
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
            },

            setPaymentFee(){

                if(this.payment_method=="PhonePe")
                this.payment_fee = 0;

                if(this.payment_method=="COD")
                this.payment_fee = this.CODFee;
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
        this.errorMessage = ""; // reset

        const billing = this.cartStore.address;
        const shipping = this.cartStore.shipping_address;

              // Cart validation
              if (this.cartStore.items.length === 0) {
            this.errorMessage = "⚠️ Your cart is empty. Please add items before checkout.";
            return;
        }


        // Billing validation
        if (!billing.name || !billing.address || !billing.town || !billing.pin_code ||
            !billing.state || !billing.phone || !billing.email) {
            this.errorMessage = "⚠️ Please complete all required Billing Address fields.";
            return;
        }

        // Shipping validation
        if (!shipping.name || !shipping.address || !shipping.town || !shipping.pin_code ||
            !shipping.state || !shipping.phone || !shipping.email) {
            this.errorMessage = "⚠️ Please complete all required Shipping Address fields.";
            return;
        }




        // ✅ If no errors, submit cart
        try {
            const response = await axios.post(route('checkout'), {
            session_id: this.cartStore.session_id,
            address: billing,
            shipping_address: shipping,
            items: this.cartStore.items,
            total_amount: this.cartTotal,
            });




            if (response.data.order_saved == 1) {

            if(this.payment_method=="COD")
            location.href = route('cod.success', [response.data.txn_id]);


            if(this.payment_method=="PhonePe")
            location.href = route('phonepe.createPayment', [response.data.order_id]);

            }
        } catch (error) {
            console.error("Error submitting cart:", error);
            this.errorMessage = "❌ Something went wrong. Please try again.";
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
