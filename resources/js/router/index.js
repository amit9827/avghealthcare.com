import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Page from '../pages/Page.vue'
import Category from '../pages/Category.vue'
import OrderStatus from '../pages/OrderStatus.vue'
import Product from '../pages/Product.vue'
import CartDisplay from '../pages/CartDisplay.vue'
import GoLink from '../components/GoLink.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/about', name: 'About', component: About },
  { path: '/category/:slug', name: 'Category', component: Category, props: true, },
  { path: '/product/:slug', name: 'Product', component: Product, props: true, },
  { path: '/go/:link', name: 'GoLink', component: GoLink },
  { path: '/cart', name: 'CartDisplay', component: CartDisplay },
  { path: '/page/:slug', name: 'Page', component: Page, props: true, },
  { path: '/order/:order_id', name: 'OrderStatus', component: OrderStatus, props: true, },




]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
