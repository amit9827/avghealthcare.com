<template>




    <footer class="p-4 bg-footer text-white"
    >

            <div class="container">
                <div class="row">

                    <div class="col-md-6">
                       <img :src="main_logo" class="footer_logo">
                        <p>Discover innovation and reliability with AVG Healthcare’s carefully developed healthcare and nutraceutical brands. We focus on scientifically crafted formulations that align with international benchmarks for safety and effectiveness.

Each product is created with the highest standards of quality, free from harmful additives, and undergoes stringent testing — helping you live healthier and more confidently every day.

                        </p>
                    </div>

                    <div class="col-md-2">

                        <span class="footer-title">Products</span>
                        <ul class="footer_menu flex-row gap-3">
                    <li
                        v-for="(item, i) in menuProducts"
                        :key="i"
                        class="nav-item "
                    >

                        <RouterLink
                        v-if="item.slug.length"
                        class="nav-link"
                        :to="{ name: 'Category', params: { slug: item.slug } }"
                        >
                        {{ item.name }}
                        </RouterLink>



                    </li>
                    </ul>
                    </div>
                    <div class="col-md-2">

                        <span class="footer-title">Ingredients</span>
                        <ul class="footer_menu flex-row gap-3">
                        <li
                        v-for="(item, i) in menuIngredients"
                        :key="i"
                        class="nav-item "
                        >
                        <RouterLink
                        v-if="item.slug.length"
                        class="nav-link"
                        :to="{ name: 'Ingredients', params: { slug: item.slug } }"
                        >
                        {{ item.name }}
                        </RouterLink>


                        </li>
                        </ul>
                        </div>
                        <div class="col-md-2">

                            <span class="footer-title">Quick Links</span>
                            <ul class="footer_menu flex-row gap-3">
                            <li
                            v-for="(item, i) in menuQuickLinks"
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

      mobileOpen: false,
      activeSubmenu: null,
      main_logo :  window.base_url + "/assets/logo_footer.svg",

    }
  },

  props: {
    menu_footer_products: {
      type: Array,
      default: () => []
    },

    menu_ingredients: {
      type: Array,
      default: () => []
    },

    menu_quick_links: {
      type: Array,
      default: () => []
    },

  },

  computed: {
    menuProducts() {

      return this.menu_footer_products; // always use prop
    },

    menuIngredients() {

      return this.menu_ingredients; // always use prop
    },



    menuQuickLinks() {

      return this.menu_quick_links; // always use prop
    },




  },

  async mounted() {

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
