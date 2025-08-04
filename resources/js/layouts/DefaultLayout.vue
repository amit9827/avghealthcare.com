<template>
    <div>
      <Navbar />
      <Header />
      <main class="p-4">
        <slot />
      </main>
      <Footer />
    </div>
  </template>

  <script setup>
  import Header from '../components/Header.vue'
  import Footer from '../components/Footer.vue'
  import Navbar from '../components/Navbar.vue'
  </script>
