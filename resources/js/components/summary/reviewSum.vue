<template>
    <div class="row">
        <sum :product="product" />
    </div>
</template>

<script>
    import Sum from "./sum";
    export default {
        name: "reviewSum",
        components: {Sum},
        props:[
            'product'
        ]
    }
</script>

<style scoped>
    div.sticky {
        position: fixed;
    }

</style>