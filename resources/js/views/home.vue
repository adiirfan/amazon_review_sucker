<template>
    <div class="m-y-3">
        <add-product />
        <product-list />
    </div>
</template>

<script>
    import productList from '../components/home/productList.vue';
    import addProduct from '../components/home/addProduct.vue';
    export default {
        name: "home",
        components:{
            productList,
            addProduct,
        }
    }
</script>

<style scoped>
     .panel-default{
         border-width:1em !important;
     }
</style>