<template>


        <div class="text-center text-white p-2" id="top-header">
            <div class="container">

                <div class="row">
                    <div class="col-md-4 text-start d-none d-md-block ">Earn Cash on Every Order</div>
                    <div class="col-md-4 ">Official Website</div>
                    <div class="col-md-4 text-end d-none d-md-block">100% Quality Assurance</div>
                </div>
            </div>
        </div>


        <div class="bg-light">
            <div class="container">
                <nav class="navbar navbar-light  border-bottom ">
                <div class="container-fluid justify-between ">
                    <RouterLink class="navbar-brand fw-bold" to="/"><img src="/assets/logo.png" class="main_logo"></RouterLink>

                    <button class="btn d-lg-none" @click="toggleMobileMenu">
                    <i class="bi bi-list fs-2"></i>
                    </button>

                    <!-- Desktop Nav -->
                    <ul class="navbar-nav d-none d-lg-flex flex-row gap-3">
                    <li
                        v-for="(item, i) in menu"
                        :key="i"
                        class="nav-item dropdown"
                    >
                        <RouterLink
                        v-if="!item.submenu?.length"
                        class="nav-link"
                        :to="item.url"
                        >
                        {{ item.title }}
                        </RouterLink>
                        <div v-else class="dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            {{ item.title }}
                        </a>
                        <ul class="dropdown-menu">
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

                    <div class=" d-none d-md-block ">
                    <input class="peer w-full me-3" placeholder="Search for " autocomplete="off" type="text" value="" name="searchField">
                    <a href="" class="text-gray p-2" ><i class="fa-solid fa-user"></i></a>
                    <a href="" class="text-gray p-2" ><i class="fa-solid fa-basket-shopping"></i></a>

                    </div>

                </div>

                <!-- Mobile Full Screen Menu -->
                <div v-if="mobileOpen" class="mobile-nav-overlay d-lg-none">
                    <div class="mobile-nav p-4">
                    <button class="btn-close float-end" @click="toggleMobileMenu"></button>
                    <ul class="list-unstyled mt-5">
                        <li
                        v-for="(item, i) in menu"
                        :key="'m' + i"
                        class="mb-2"
                        >
                        <div v-if="item.submenu?.length">
                            <div
                            class="fw-bold"
                            @click="toggleSubmenu(i)"
                            style="cursor: pointer"
                            >
                            {{ item.title }}
                            </div>
                            <ul v-show="activeSubmenu === i" class="ms-3 mt-2">
                            <li
                                v-for="(sub, j) in item.submenu"
                                :key="j"
                            >
                                <RouterLink class="d-block py-1" :to="sub.url">
                                {{ sub.title }}
                                </RouterLink>
                            </li>
                            </ul>
                        </div>
                        <div v-else>
                            <RouterLink :to="item.url" class="fw-bold d-block">
                            {{ item.title }}
                            </RouterLink>
                        </div>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>
            </div>
            </div>
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
      menu: [],
      mobileOpen: false,
      activeSubmenu: null,
    }
  },
  methods: {
    toggleMobileMenu() {
      this.mobileOpen = !this.mobileOpen
      this.activeSubmenu = null
    },
    toggleSubmenu(index) {
      this.activeSubmenu = this.activeSubmenu === index ? null : index
    },
  },
  async mounted() {
    try {
      const response = await axios.get(route('menu'))
      this.menu = response.data
    } catch (error) {
      console.error('Menu fetch failed:', error)
    }
  },
}
</script>

<style scoped>
body{
    background-color: #fff;
}
.mobile-nav-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 1050;
  overflow-y: auto;
  transition: all 0.3s ease-in-out;
}

.mobile-nav {
  max-width: 90%;
  margin: auto;
}

.navbar-nav .dropdown-menu {
  top: 100%;
  position:absolute;

}

.main_logo{
    height:60px;
}


</style>
