<template>
    <div>
      <Navbar />
      <Header />
      <main class="p-0 bg-white">
        <slot />
      </main>
      <FloatingCart :itemCount="3" :total="1147" :show="true" />
      <FloatingContactButtons phone-number="918888812345" whatsapp-number="918888812345" />

      <Footer />
    </div>
  </template>

  <script setup>
  import Header from '../components/Header.vue'
  import Footer from '../components/Footer.vue'
  import Navbar from '../components/Navbar.vue'
  import FloatingCart from '../components/FloatingCart.vue'
  import FloatingContactButtons from '../components/FloatingContactButtons.vue'
  </script>
