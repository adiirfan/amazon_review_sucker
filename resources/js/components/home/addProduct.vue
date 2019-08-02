<template>
    <div class="row m-y-2">
        <div class="col-md-12 ">
            <h3>Add Product</h3>
            <div class="form-group has-focus detach-feedback m-y-2">
                <label v-if="error === 1" class="control-label" for="addProduct">
                    {{errorMsg}}
                </label>
                <div class="input-group" :class="error === 1 ? 'has-error' : ''">
                    <input type="text" class="form-control"
                           aria-describedby="detached-help-feedback" id="addProduct" aria-invalid="true" v-model="ASIN" placeholder="add product ASIN" v-on:keypress.enter="addProduct()">
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
                error:0,
                errorMsg:''
            }
        },
        methods:{
            async addProduct(){
                await this.$http.post('/scrape', {
                    ASIN: this.ASIN,
                    })
                    .then(response => {
                        window.location.href = '/'+this.ASIN
                    })
                    .catch(error => {
                        if(error.response.status === 401){
                            window.location.href = '/login'
                        }else{
                            this.error = 1;
                            this.errorMsg = error.response.data.errors
                            console.log(error.response.data)
                        }
                    })
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>