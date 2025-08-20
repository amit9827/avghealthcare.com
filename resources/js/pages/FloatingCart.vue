<template>
    <div
      v-if="show && itemCount > 0"
      class="position-fixed bottom-0 start-50 translate-middle-x w-100 bg-white shadow p-3 z-index-sticky d-flex justify-content-between align-items-center"
      style="max-width: 500px; border-radius: 0.5rem;"
    >
      <div>
        <h6 class="mb-0 fw-semibold text-dark">
          {{ itemCount }} Item{{ itemCount > 1 ? 's' : '' }} | ₹ {{ total }}
        </h6>
      </div>
      <RouterLink to="/cart" class="btn btn-warning text-white fw-semibold px-4">
        GO TO CART
      </RouterLink>
    </div>
  </template>

  <script>
  import { computed } from 'vue'
  import { RouterLink } from 'vue-router'
  import { cartStore } from '../cartStore' // adjust path as needed

  export default {
    name: 'FloatingCart',
    components: { RouterLink },
    props: {
      show: {
        type: Boolean,
        default: true,
      },
    },
     setup(props) {
  // Compute total item count from cartStore.items
  const itemCount = computed(() =>
    cartStore.items.reduce((acc, item) => acc + item.quantity, 0)
  )

  // Compute total price considering sale price if available
  const total = computed(() =>
    cartStore.items.reduce((acc, item) => {
      let price = item.product.regular_price
      if (item.product.onsale == 1) {
        price = item.product.sale_price
      }
      return acc + price * item.quantity
    }, 0)
  )

  return {
    itemCount,
    total,
    show: props.show,
  }
},

  }
  </script>

  <style scoped>
  .z-index-sticky {
    z-index: 1050;
  }
  </style>
