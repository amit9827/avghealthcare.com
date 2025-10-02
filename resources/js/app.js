/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';



import { createApp } from 'vue'
import { createHead } from '@vueuse/head'
import App from './App.vue'
import router from './router'

import './assets/styles.css'   // global CSS
import { registerSW } from 'virtual:pwa-register'


const app = createApp(App)
app.use(router)
app.use(createHead())
app.mount('#app')


const updateSW = registerSW({
  onNeedRefresh() {
    if (confirm("New content available. Refresh?")) {
      updateSW()
    }
  },
  onOfflineReady() {
    console.log("App ready to work offline")
  }
})
