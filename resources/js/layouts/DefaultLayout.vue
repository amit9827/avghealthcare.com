<template>
    <div>
      <Navbar :menu_header_products="menu_header_products"   phone-number="+919501106343" whatsapp-number="919501106343" />
      <Header />
      <main class="p-0 bg-white">
        <slot />
      </main>

      <FloatingContactButtons phone-number="+919501106343" whatsapp-number="919501106343" />

      <Footer
        :menu_footer_products="menu_footer_products"
        :menu_ingredients="menu_ingredients"
        :menu_quick_links="menu_quick_links"
      />
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import { route } from 'ziggy-js'

  import Header from '../components/Header.vue'
  import Footer from '../components/Footer.vue'
  import Navbar from '../components/Navbar.vue'
  import FloatingCart from '../components/FloatingCart.vue'
  import FloatingContactButtons from '../components/FloatingContactButtons.vue'

  // reactive state
  const menu_header_products = ref([])
  const menu_footer_products = ref([])
  const menu_ingredients = ref([])
  const menu_quick_links = ref([])

  onMounted(async () => {
    try {
      const response = await axios.get(route('menu'))

      menu_header_products.value = response.data.menu_products || []
      menu_footer_products.value = response.data.footer_menu_products || []
      menu_ingredients.value = response.data.menu_ingredients || []
      menu_quick_links.value = response.data.menu_quick_links || []


    } catch (error) {
      console.error('Menu fetch failed:', error)
    }
  })
  </script>
