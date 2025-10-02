<template>
    <DefaultLayout>
      <div class="container">
        <!-- Breadcrumb -->
        <p class="p-2">
          <RouterLink class="nav-link inline" :to="{ name: 'Home' }">Home</RouterLink> /
          Search results
        </p>

        <!-- Banner (optional from API) -->
        <template v-if="banner">
          <HomeBanner :src="getpath(banner)" alt="Search Banner" />
        </template>

        <!-- Header Row -->
        <div class="row mb-3">
          <div class="col-md-2">
            <h1 class="ms-3 para1_title">{{ searchQuery }}</h1>
          </div>
          <div class="col-md-10">
            <div v-if="filters.length">
              <ul class="nav nav-pills gap-2 flex-nowrap" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link rounded-pill border px-3 py-1 text-capitalize active"
                    type="button"
                    role="tab"
                    @click="applyFilter('all')"
                  >
                    All
                  </button>
                </li>

                <div v-for="filter in filters" :key="filter">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link rounded-pill border px-3 py-1 text-capitalize"
                      type="button"
                      role="tab"
                      @click="applyFilter(filter)"
                    >
                      {{ filter }}
                    </button>
                  </li>
                </div>
              </ul>
            </div>
          </div>
        </div>

        <!-- Sort -->
        <div class="row">
          <div class="col-md-12 text-end">

          </div>
        </div>

        <!-- Products -->
        <div class="row">
          <div class="col-md-12">

            <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p>Loading results...</p>
    </div>

            <div v-else-if="products.length">
              <Products :products="products" />
            </div>
            <div v-else class="text-center py-5">
              <h4>No results found for "{{ searchQuery }}"</h4>
              <p>

              <RouterLink class="navbar-brand fw-bold" to="/">
                Click here to go to Home Page
            </RouterLink>
        </p>

            </div>
          </div>
        </div>
      </div>

      <FloatingCart :itemCount="3" :total="1147" :show="true" />
    </DefaultLayout>
  </template>

  <script>
  import DefaultLayout from "../layouts/DefaultLayout.vue";
  import HomeBanner from "../components/HomeBanner.vue";
  import Products from "../components/Products.vue";
  import FloatingCart from "../components/FloatingCart.vue";

  import { useHead } from "@vueuse/head";
  import axios from "axios";
  import { route } from "ziggy-js";

  export default {
    name: "SearchResults",
    components: { HomeBanner, DefaultLayout, Products, FloatingCart },
    data() {
      return {
        searchQuery: this.$route.query.q || "",
        products: [],
        filters: [], // e.g., categories, tags, brands
        sortBy: "",
        banner: "", // optional
        loading: false, // <--- add this

      };
    },
    watch: {
      "$route.query.q": {
        immediate: true,
        handler(newQuery) {
          this.searchQuery = newQuery;
          this.fetchResults(newQuery);
          this.updateHead(newQuery);
        },
      },
    },
    methods: {


      async fetchResults(query) {
  if (!query) return;
  this.loading = true; // start loading
  try {
    const url = `${route("product_search")}?q=${query}`;
    const res = await axios.get(url);

    this.products = res.data.products;
    this.filters = res.data.filters || [];
    this.banner = res.data.banner || "";
  } catch (err) {
    console.error(err);
  } finally {
    this.loading = false; // stop loading
  }
},



      applyFilter(filter) {
        if (filter === "all") {
          this.fetchResults(this.searchQuery);
        } else {
          this.products = this.products.filter((p) =>
            p.tags?.includes(filter)
          );
        }
      },
      applySort() {
        if (this.sortBy === "price_asc") {
          this.products.sort((a, b) => Number(a.price) - Number(b.price));
        } else if (this.sortBy === "price_desc") {
          this.products.sort((a, b) => Number(b.price) - Number(a.price));
        } else if (this.sortBy === "rating_desc") {
          this.products.sort(
            (a, b) => Number(b.average_rating) - Number(a.average_rating)
          );
        }
      },
      getpath(path) {
        return "..\\images\\" + path;
      },
      updateHead(query) {
        useHead({
          title: `Search: ${query} | AVG Healthcare`,
          meta: [
            {
              name: "description",
              content: `Search results for ${query} on AVG Healthcare.`,
            },
          ],
        });
      },
    },
  };
  </script>

  <style>
  .nav-pills .nav-link {
    border-color: #d9f99d;
    font-weight: 300;
    font-size: 0.9rem;
  }

  .nav-pills .nav-link.active {
    background-color: #eff6ff;
    border-color: #eff6ff;
    font-weight: 500;
  }

  .para1_title {
    font-size: 18px;
  }

  #sort_by {
    margin: 10px 20px;
  }
  </style>
