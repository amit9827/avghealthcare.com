<template>
    <div>
      <div v-if="products.length" class="row mb-5">
        <div v-for="product in products" :key="product.id" class="col-md-3 col-6 product">

<div href="#" class="product-card h-100 d-flex flex-column">

   <RouterLink
  :to="{ name: 'Product', params: { slug: product.slug } }"
  class="d-flex flex-column justify-content-start gap-2 gap-md-3 align-self-stretch rounded p-1 p-md-0 bg-white h-auto text-decoration-none text-black"
>


          <img :src="getpath(product.featured_image)" class="product_img">



          <div v-if="product.benefits_tags" class="m-2 ms-0 mb-2">
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
        </div>
        <p class="para1_heading mb-0">{{ product.title }}</p>
        <p class="para3_content" v-if="product.ingredients_tags">
        <span v-for="(sub, index) in product.ingredients_tags.split(`,`)"
        :key="index"
        >
        {{ sub.trim() }} |
        </span>

        </p>
    </RouterLink>



    <div class="mt-auto">
        <div class="product_reviews "><i class="fa-solid fa-star text-warning" data-v-bfe846de=""></i> {{ product.rating_count }} ({{ product.average_rating }}) Reviews</div>

        <div class="row">

        <div class="p2_heading product_price col-7" v-if="product.onsale" ><del class="text-gray-light">₹{{ product.regular_price}}</del> ₹{{ product.sale_price}}</div>
        <div class="p2_heading product_price col-7" v-else >₹{{ product.regular_price}}</div>

        <div class="text-end col-5">


        <button
    type="button"
    class="btn btn-warning text-white fw-medium text-capitalize   rounded add_btn"

    aria-label="Add Button" @click="add(product)"
    v-if="!getQuantity(product)"
    >
    Add
    </button>

<div class="product_quantity text-end "   v-if="getQuantity(product)">
    <div class="quantity-grid border rounded overflow-hidden ms-auto">
      <button type="button"  @click="decrement(product)" class="btn quantity-btn">-</button>
      <span class="quantity-value">{{ getQuantity(product) }}</span>
      <button type="button"  @click="increment(product)" class="btn quantity-btn">+</button>
    </div>
  </div>

</div>
</div>


</div>



    </div>

        </div>
      </div>

      <div v-else>
        <p>No products found.</p>
      </div>
    </div>
  </template>


  <script>
   import { mutations, getters } from '../cartStore'



  export default {
    name: 'Products',
    props: {
      products: {
        type: Array,
        default: () => []
      },

    },


    data()  {
        return {
            colors: [
        "rgb(203, 237, 243)", // light blue
        "rgb(255, 230, 230)", // light red
        "rgb(230, 255, 230)", // light green
        "rgb(255, 245, 204)", // light yellow
        "rgb(230, 230, 255)", // light purple
        "rgb(255, 240, 245)"  // light pink
      ]


        }
    },
    mounted() {
      console.log(this.products)
    },


    watch: {
  products(newVal) {
    console.log("Products updated:", newVal)
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

    getRandomColor(index) {
      // Using index for consistent color assignment across renders
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



},
  }
  </script>

  <style scoped>
  .product {


    overflow: hidden;
  }

  .product_frame{

    border: 1px solid #000;
    padding: 10px;

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


  .product_img{

    max-width:100%;
    height:auto;
    width:auto;
    border-radius: 10px;
  }


  .para1_heading{
    font-size: 1.25rem;
    font-size: bolder;
    color:#000;
    font-weight: bold;

  }

  .p2_heading{
    font-size: 1rem;
    font-weight: bold;
  }

  .para3_content{
    font-size:.875rem;
  }

  .quantity-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  width: 4.5rem;
  height: 34.5px;
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

.add_btn{
    min-width: 4.5rem;
    width: 2rem;
  }

@media (max-width: 767px) {
    .para1_heading{
    font-size: 0.75rem;
  }

  .para3_content{
    font-size:.5em;
  }

  .add_btn{
    min-width: 2.5rem;
    width: 2rem;
    padding: 5px;
  }

  .product {

    padding:1px;
  }

}


  </style>
