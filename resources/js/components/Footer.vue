<template>




    <footer class="p-4 bg-footer text-white"
    >

            <div class="container">
                <div class="row">

                    <div class="col-md-6">
                       <img :src="main_logo" class="footer_logo">
                        <p>Experience the purity and performance of our curated brands — WOW Skin Science, WOW Life Science, Body Cupid, Color Cupid, and Nature Derma. Each range is thoughtfully formulated without harmful sulfates, silicones, or parabens, and many are dermatologically tested to support your well-being. Discover science-backed supplements, clean beauty essentials, luxurious bath & body care, high-performance makeup, and targeted skincare solutions — all crafted to help you look and feel your best every day.

                        </p>
                    </div>

                    <div class="col-md-2">

                        <span class="footer-title">Products</span>
                        <ul class="footer_menu flex-row gap-3">
                    <li
                        v-for="(item, i) in menu_products"
                        :key="i"
                        class="nav-item "
                    >
                        <RouterLink
                        v-if="item.url"
                        class="nav-link"
                        :to="item.url"
                        >
                        {{ item.name }}
                        </RouterLink>
                        <div v-else class="dropdown2">
                        <a
                            class="nav-link"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            {{ item.name }}
                        </a>
                        <ul class="dropdown2-menu">
                            <li
                            v-for="(sub, j) in item.submenu"
                            :key="j"
                            >
                            <RouterLink class="dropdown-item" :to="sub.url">
                                {{ sub.title }}
                            </RouterLink>
                            </li>
                        </ul>
                        </div>
                    </li>
                    </ul>
                    </div>
                    <div class="col-md-2">

                        <span class="footer-title">Ingredients</span>
                        <ul class="footer_menu flex-row gap-3">
                        <li
                        v-for="(item, i) in menu_ingredients"
                        :key="i"
                        class="nav-item "
                        >
                        <RouterLink
                        v-if="item.url"
                        class="nav-link"
                        :to="item.url"
                        >
                        {{ item.title }}
                        </RouterLink>
                        <div v-else class="dropdown2">
                        <a
                            class="nav-link"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            {{ item.title }}
                        </a>
                        <ul class="dropdown2-menu">
                            <li
                            v-for="(sub, j) in item.submenu"
                            :key="j"
                            >
                            <RouterLink class="dropdown-item" :to="sub.url">
                                {{ sub.title }}
                            </RouterLink>
                            </li>
                        </ul>
                        </div>
                        </li>
                        </ul>
                        </div>
                        <div class="col-md-2">

                            <span class="footer-title">Quick Links</span>
                            <ul class="footer_menu flex-row gap-3">
                            <li
                            v-for="(item, i) in menu_quick_links"
                            :key="i"
                            class="nav-item "
                            >
                            <RouterLink
                            v-if="item.url"
                            class="nav-link"
                            :to="item.url"
                            >
                            {{ item.title }}
                            </RouterLink>
                            <div v-else class="dropdown2">
                            <a
                                class="nav-link"
                                href="#"
                                data-bs-toggle="dropdown"
                            >
                                {{ item.title }}
                            </a>
                            <ul class="dropdown2-menu">
                                <li
                                v-for="(sub, j) in item.submenu"
                                :key="j"
                                >
                                <RouterLink class="dropdown-item" :to="sub.url">
                                    {{ sub.title }}
                                </RouterLink>
                                </li>
                            </ul>
                            </div>
                            </li>
                            </ul>
                            </div>
                </div>


                <div class="text-cemter text-sm">
                    &copy; 2025 AVG Healthcare. All rights reserved | Site Design : <a href="" class="text-white">webTech (India & UK)</a>
                </div>
            </div>
    </footer>
</template>


<script>
import { RouterLink } from 'vue-router'
import axios from 'axios'
import { route } from 'ziggy-js'

export default {
  name: 'Navbar',
  components: { RouterLink },
  data() {
    return {
      menu_products: [],
      menu_ingredients: [],
      menu_quick_links: [],
      mobileOpen: false,
      activeSubmenu: null,
      main_logo :  window.base_url + "/assets/logo_footer.svg",

    }
  },


  async mounted() {
    try {
      const response = await axios.get(route('menu'))

      this.menu_products = response.data.menu_products || []
      this.menu_ingredients = response.data.menu_ingredients || []
      this.menu_quick_links = response.data.menu_quick_links || []


    } catch (error) {
      console.error('Menu fetch failed:', error)
    }
  },
}

</script>

<style scoped>
.bg-footer{
    background-color: #5c7775;
}

.footer-title{
    font-size: 16px;
    font-weight:bold;

}

.footer_logo{
    height:100px;
    margin-left: -20px;
    margin-bottom:20px;
}

.footer_menu {
list-style: none;
margin-left: -30px;
margin-top:10px;
}
</style>
