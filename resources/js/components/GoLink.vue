<template>
  <div>Redirecting... to <a :href="`/${relativePath}`" >{{ relativePath}}</a></div>

</template>

<script >

export default{

    data() {
        return{
            relativePath : '',
        }
    },
    mounted(){
        this.relativePath = decodeURIComponent(this.$route.params.link);
        window.location.href= `/${this.relativePath}`;
    }
}


</script>
