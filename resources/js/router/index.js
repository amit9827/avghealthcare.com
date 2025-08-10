import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Category from '../pages/Category.vue'
import CartDisplay from '../pages/CartDisplay.vue'
import GoLink from '../components/GoLink.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/about', name: 'About', component: About },
  { path: '/category/:slug', name: 'Category', component: Category, props: true, },
  { path: '/go/:link', name: 'GoLink', component: GoLink },
  { path: '/cart', name: 'CartDisplay', component: CartDisplay },




]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
