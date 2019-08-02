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
            <div class="col-md-12 col-xs-12 m-y-1" v-if="!loading">
                <review-list :data="listReview"></review-list>
            </div>
            <div class="col-md-12 m-y-1">
                <nav>
                    <ul class="pagination">
                        <li class="paging" :class="page === 1 ? 'disabled' : ''">
                            <a aria-label="Previous" v-on:click="page > 1 ? nextpage(page - 1): ''">
                                <span aria-hidden="true">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                </span>
                            </a>
                        </li>
                        <li class="paging" v-for="n in sort" :class="paging - 10 + n === page ? 'active' : ''" v-on:click="nextpage(paging - 10 + n)">
                            <a>
                                <span>{{paging - 10 + n }}<span v-if="n === page" class="sr-only">(current)</span></span>
                            </a>
                        </li>
                        <li class="paging">
                            <a aria-label="Next" v-on:click="nextpage(page + 1)">
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
                totalpage: '',
                n: 1,
                paging: 10,
                sort: 10,
                loading:true,
            }
        },
        mounted(){
            this.getProduct()
            if(this.$route.query.page){
                var x = this.$route.query.page
                this.page = parseInt(x)
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
                        if(error.response.status === 401){
                            window.location.href = '/login'
                        }else{
                            window.location.href = '/'
                        }
                    })
                    .finally(() => this.loading = false)
            },
            async getReview(){
                this.$http.get('/product/'+ this.$route.params.productId+'/review?verif='+this.verif+'' +
                    '&star='+this.star+'&page='+this.page)
                    .then(response => {
                        this.listReview = response.data.data
                        this.totalpage = response.data.last_page
                        if(this.totalpage < 10){
                            this.sort = this.totalpage;
                        }
                        if(this.page > this.paging) {
                            do {
                                this.paging = this.paging + 10
                            }
                            while (this.page > this.paging);
                        }
                    })
                    .catch(error => {
                        if(error.response.status === 401){
                            window.location.href = '/login'
                        }else{
                            window.location.href = '/'
                        }
                    })
                    .finally(() => this.loading = false)
            },
            nextpage(data){
                var query = this.$route.query;
                var newPage = data;
                this.$router.push({ path: '/'+this.$route.params.productId, query: {...query, page: newPage}})
                this.loading = true;
                if(this.$route.query.page){
                    var x = this.$route.query.page
                    this.page = parseInt(x)
                }
                if(this.$route.query.verif){
                    this.verif = this.$route.query.verif
                }
                if(this.$route.query.star){
                    this.star = '['+this.$route.query.star+']'
                }
                this.getReview()
            },
        }
    }
</script>

<style scoped>
    .paging {
        cursor: pointer;
    }
</style>