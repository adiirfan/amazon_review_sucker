<template>
    <div class="row" v-if="loading">
        <div class="col-md-12 m-y-3">
            <h3>Tag List</h3>
        </div>
        <div class="col-md-12 m-y-1">
            <p>
                <button v-for="(tag,key) in data" v-bind:key="key" v-on:click="openDetail(tag.tags)" type="button" class="btn  btn-primary m-x-2 m-y-2" >
                    {{tag.tags_review.tagsName}} ( {{tag.total}} )
                </button>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "analyze",
        data(){
            return{
                data:'',
                loading:false
            }
        },
        mounted(){
            this.getTags();
        },
        methods:{
            async getTags(){
                await this.$http.get('/tags/analyze/')
                    .then(response => {
                        this.data = response.data
                    })
                    .catch(error => {
                        if(error.response.status === 401){
                            window.location.href = '/login'
                        }else{
                            window.location.href = '/'
                        }
                    })
                    .finally(() => this.loading = true)
            },
            openDetail(id){
                window.location.href = '/analyze/'+id;
            }
        }
    }
</script>

<style scoped>

</style>