import { reactive } from 'vue'

export const cartStore = reactive({
  items: [], // { product, quantity }
})

export const mutations = {
  addToCart(product) {
    const item = cartStore.items.find(i => i.product.id === product.id)
    if (item) {
      item.quantity++
    } else {
      cartStore.items.push({ product, quantity: 1 })
    }
  },

  incrementQuantity(product) {
    const item = cartStore.items.find(i => i.product.id === product.id)
    if (item) {
      item.quantity++
    }
  },

  decrementQuantity(product) {
    const item = cartStore.items.find(i => i.product.id === product.id)
    if (item) {
      if (item.quantity > 1) {
        item.quantity--
      } else {
        // Remove if quantity goes below 1
        this.removeFromCart(product.id)
      }
    }
  },

  removeFromCart(productId) {
    const index = cartStore.items.findIndex(i => i.product.id === productId)
    if (index !== -1) {
      cartStore.items.splice(index, 1)
    }
  },

  clearCart() {
    cartStore.items = []
  },
}

export const getters = {
  getProductQuantity(productId) {
    const item = cartStore.items.find(i => i.product.id === productId)
    return item ? item.quantity : 0
  },
}
