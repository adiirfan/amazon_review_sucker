<template>
    <div class="row m-y-2">
        <div class="col-md-12 ">
            <h3>Add Product</h3>
            <div class="form-group has-focus detach-feedback m-y-2">
                <div class="input-group">
                    <input type="text" class="form-control"
                           aria-describedby="detached-help-feedback" v-model="ASIN" placeholder="add product ASIN" v-on:keypress.enter="addProduct()">
                    <div class="input-group-btn">
                        <button class="btn btn-addon">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "addProduct",
        data(){
            return{
                ASIN:'',
            }
        },
        methods:{
            async addProduct(){
                await this.$http.post('/scrape', {
                    ASIN: this.ASIN,
                    })
                    .then(response => {
                        console.log(response.data)
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