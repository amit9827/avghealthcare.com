<template>
    <div
      v-if="show"
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
  import { RouterLink } from 'vue-router'

  export default {
    name: 'FloatingCart',
    components: { RouterLink },
    props: {
      itemCount: {
        type: Number,
        required: true,
      },
      total: {
        type: Number,
        required: true,
      },
      show: {
        type: Boolean,
        default: true,
      },
    },
  }
  </script>

  <style scoped>
  .z-index-sticky {
    z-index: 1050;
  }
  </style>
