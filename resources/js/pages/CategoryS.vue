<template>
    <div>
      <h1>Category: {{ slug }}</h1>
      <div v-if="items.length">
        <div v-for="item in items" :key="item.id">{{ item.name }}</div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios'

  export default {
    props: ['slug'],
    data() {
      return {
        items: []
      }
    },
    mounted() {

        let url =  route('category', [slug]);

      axios.get(url)
        .then(res => {
          this.items = res.data
        })
    }
  }
  </script>
