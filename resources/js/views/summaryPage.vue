<template>
    <div>
        <div class="jumbotron" v-if="status !== 2">
            <h3>Hello</h3>
            <p>Currently your data still processed,please wait for a while</p>
            <p><a class="btn btn-primary btn-sm" href="/" role="button">back to home</a></p>
        </div>
        <div class="row" v-else>
            <div class="col-md-12 col-xs-12 m-y-1">
                <review-sum :product="data"/>
            </div>
            <div class="col-md-12 col-xs-12 m-y-1">
                <review-list :data="listReview"></review-list>
            </div>
            <div class="col-md-12 m-y-1">
                <nav>
                    <ul class="pagination">
                        <li class="disabled">
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <span>1 <span class="sr-only">(current)</span></span>
                        </li>
                        <li>
                            <a href="">2</a>
                        </li>
                        <li>
                            <span>...</span>
                        </li>
                        <li>
                            <a href="">12</a>
                        </li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    import reviewList from '../components/summary/reviewList.vue';
    import ReviewSum from "../components/summary/reviewSum";
    export default {
        name: "summaryPage",
        components:{
            ReviewSum,
            reviewList,
        },
        data(){
            return{
                status: 0,
                data: [],
                star:"",
                verif:"",
                listReview:[],
                page:1,
            }
        },
        mounted(){
            this.getProduct()
            if(this.$route.query.page){
                this.page = this.$route.query.page
            }
            if(this.$route.query.verif){
                this.verif = this.$route.query.verif
            }
            if(this.$route.query.star){
                this.star = '['+this.$route.query.star+']'
            }
            this.getReview();
        },
        methods:{
            async getProduct(){
                this.$http.get('/product/'+ this.$route.params.productId)
                    .then(response => {
                        if (response.data.hasOwnProperty('queue')) {
                            this.data = response.data
                            this.status = response.data.queue.queueStatus;
                            console.log(this.status)
                        }
                    })
                    .catch(error => {
                        window.location.href = '/'
                    })
                    .finally(() => this.loading = false)
            },
            async getReview(){
                this.$http.get('/product/'+ this.$route.params.productId+'/review?verif='+this.verif+'' +
                    '&star='+this.star+'&page='+this.page)
                    .then(response => {
                        this.listReview = response.data.data
                    })
                    .catch(error => {
                        window.location.href = '/'
                    })
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>

</style>