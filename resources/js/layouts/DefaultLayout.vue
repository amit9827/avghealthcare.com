<template>
    <div>
      <Navbar />
      <Header />
      <main class="p-0 bg-white">
        <slot />
      </main>

      <FloatingContactButtons phone-number="+919501106343" whatsapp-number="919501106343" />

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
