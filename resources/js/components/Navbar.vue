<template>
    <!-- Top Header -->
    <div class="text-center text-white p-2 bg-top-header" id="top-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 text-start d-none d-md-block"><i class="fa fa-phone"></i> Call  : {{phoneNumber}}</div>
          <div class="col-md-4">From Herbal Remedies to Wellness Solutions</div>
          <div class="col-md-4 text-end d-none d-md-block">100% Quality Assurance</div>
        </div>
      </div>
    </div>

    <!-- Main Navbar -->
    <div class="bg-light sticky-top shadow-sm">
      <div class="container">
        <nav class="navbar navbar-light border-bottom py-2">
          <div class="container-fluid justify-between">
            <!-- Logo -->
            <RouterLink class="navbar-brand fw-bold" to="/">
              <img :src="main_logo" class="main_logo" />
            </RouterLink>





            <!-- Right Icons + Search -->
            <div class="d-md-flex align-items-center gap-3" >
              <div class="search-box d-flex align-items-center">
                <input
        class="form-control"
        placeholder="Search product…"
        autocomplete="off"
        type="text"
        v-model="searchText"
        @keyup.enter="doSearch"
      />
      <i
        class="fa-solid fa-magnifying-glass ms-2 text-muted"
        style="cursor:pointer"
        @click="doSearch"
      ></i>


              <RouterLink class="text-gray ps-3" :to="cart">
                <i class="fa-solid fa-basket-shopping text-gray"></i>
              </RouterLink>
            </div>
        </div>

               <!-- Mobile Menu Toggle -->
               <button class="btn d-lg-none" @click="toggleMobileMenu">
                <i class="fa-solid fa-bars fs-2"></i>

            </button>



          </div>







          <!-- Mobile Sidebar Menu -->
          <div v-if="mobileOpen" class="sidebar-overlay d-lg-none" @click.self="toggleMobileMenu">
  <div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header d-flex justify-content-between align-items-center px-3 py-3 text-white">
      <div class="d-flex align-items-center">
        <img :src="logo_footer" class="sidebar-logo me-2" />
        <div>


          <div class="fw-bold">Hi Guest</div>

          <RouterLink class="text-white small text-decoration-none" :to="cart" @click="toggleMobileMenu">
                <i class="fa-solid fa-basket-shopping"></i> Cart
              </RouterLink>

        </div>
      </div>
      <button class="btn-close btn-close-white" @click="toggleMobileMenu"></button>
    </div>

    <!-- Sidebar Menu -->
    <ul class="list-unstyled mb-0">
      <li
        v-for="(item, i) in menu"
        :key="'m' + i"
        class="sidebar-item border-bottom"
      >
        <!-- Has Submenu -->
        <div v-if="item.submenu?.length">
          <div
            class="fw-bold d-flex justify-content-between align-items-center px-3 py-3"
            @click="toggleSubmenu(i)"
            style="cursor: pointer"
          >
            {{ item.name }}
            <i class="fa-solid" :class="activeSubmenu === i ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
          </div>
          <ul v-show="activeSubmenu === i" class="list-unstyled ms-3 mb-2">
            <li v-for="(sub, j) in item.submenu" :key="j">
              <RouterLink class="d-block px-3 py-2 text-muted" :to="sub.url">
                {{ sub.title }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- No Submenu -->
        <div v-else>
          <RouterLink
            v-if="item.slug"
            :to="{ name: 'Category', params: { slug: item.slug } }"
            class="fw-bold d-block px-3 py-3 no-underline" @click="toggleMobileMenu"
          >
            {{ item.name }}
          </RouterLink>
          <span v-else class="fw-bold d-block px-3 py-3">{{ item.name }}</span>
        </div>
      </li>
    </ul>
  </div>
</div>








        </nav>
        <div class="align-center" >
            <!-- Desktop Nav -->
    <ul class="navbar-nav d-none d-lg-flex flex-row gap-3 align-items-center p-1 ps-2 align-center"  >
              <li v-for="(item, i) in menu" :key="i" class="nav-item dropdown">
                <!-- Simple link -->
                <RouterLink
                  v-if="item.slug?.length"
                  class="nav-link"
                  active-class="active"
                  :to="{ name: 'Category', params: { slug: item.slug } }"
                >
                  {{ item.name }}
                </RouterLink>

                <!-- Dropdown -->
                <div v-else class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    {{ item.name }}
                  </a>
                  <ul class="dropdown-menu">
                    <li v-for="(sub, j) in item.submenu" :key="j">
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
    </div>
  </template>

  <script>
  import { RouterLink } from "vue-router";
  import axios from "axios";
  import { route } from "ziggy-js";

  export default {
    name: "Navbar",
    components: { RouterLink },
    data() {
      return {

        mobileOpen: false,
        activeSubmenu: null,
        searchText: "",
        main_logo: window.base_url + "/assets/logo.svg",
        logo_footer: window.base_url + "/assets/logo_footer.svg",
        cart: "/cart",
      };
    },

    props: {
    menu_header_products: {
      type: Array,
      default: () => []
    },
    phoneNumber: {
        type: String,
        default: '+919501106343', // Replace with your number
    },
    whatsappNumber: {
    type: String,
    default: '919501106343', // Replace with your number (country code + number)
    },
  },




    methods: {
      toggleMobileMenu() {
        this.mobileOpen = !this.mobileOpen;
        this.activeSubmenu = null;
      },
      toggleSubmenu(index) {
        this.activeSubmenu = this.activeSubmenu === index ? null : index;
      },

      doSearch() {
      if (this.searchText.trim()) {
        this.$router.push({
          name: "SearchResults",   // route name
          query: { q: this.searchText }
        });
        this.searchText = ""; // clear after search (optional)
      }
    },

    },

    computed: {
    menu() {

      return this.menu_header_products; // always use prop
    }
  },
  };
  </script>

  <style scoped>
  /* Top header bar */
  .bg-top-header {
    background-color: #5c7775;
  }
  .main_logo {
    height: 60px;
  }

  /* Hover dropdown on desktop */
  .nav-item.dropdown:hover > .dropdown-menu {
    display: block;
  }
  .nav-link.active {
    color: #013d1b;
    font-weight: 600;
  }

  /* Search styling */
  .search-box input {
    border-radius: 50px;
    padding: 0.4rem 1rem;
    border: 1px solid #ddd;
    width: 220px;
  }
  .search-box input:focus {
    outline: none;
    border-color: #ed7f30;
    box-shadow: 0 0 0 0.2rem rgba(237, 127, 48, 0.25);
  }

  /* Sidebar Menu (Mobile Only) */
/* Overlay background */
.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1050;
}

/* Sidebar drawer */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 85%;
  max-width: 320px;
  background: #fff;
  overflow-y: auto;
  animation: slideIn 0.3s forwards;
}

/* Orange header */
.sidebar-header {
  background-color: #314946; /* adjust to your theme */
}

/* Logo */
.sidebar-logo {
  height: 40px;
}

/* Menu styling */
.sidebar-item {
  font-size: 1rem;
}
.sidebar-item .fw-bold {
  color: #333;
}
.sidebar-item .fw-bold:hover {
  background: #f9f9f9;
}

.no-underline{
    text-decoration: none;
}

.text-gray{
    color:#333;
}

.align-center{
   margin: 0px auto;

}

/* Slide in animation */
@keyframes slideIn {
  from {
    transform: translateX(-100%);
  }
  to {
    transform: translateX(0);
  }
}


  </style>

