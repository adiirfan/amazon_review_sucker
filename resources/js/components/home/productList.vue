<template>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-xs-center text-md-left">Product List</h3>
        </div>
        <div class="col-md-3 m-y-3 " v-for="(data,key) in product" v-bind:key="key">
            <div class="card" :class="data.queue.queueStatus === 2 ? 'card-done' : 'card-progress'">
                <div class="card-body">
                    <h4 class="panel-title">{{data.ASIN}}</h4>
                    <p>{{data.product.productName}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "productList",
        data(){
            return{
                product:[],
            }
        },
        mounted(){
            this.getProduct();
        },
        methods:{
            async getProduct(){
                await this.$http.get('/product')
                    .then(response => {
                        this.product = response.data.data
                    })
                    .catch(error => {
                        console.log(error)

                    })
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>