<template>
    <div>
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
</template>

<script>
    import reviewList from '../components/summary/reviewList.vue';
    export default {
        name: "analyzeDetail",
        data(){
            return{
                status: 0,
                listReview:[],
                page:1,
                totalpage: '',
                n: 1,
                paging: 10,
                sort: 10,
                loading:true,
            }
        },
        components:{
            reviewList,
        },
        mounted(){
            if(this.$route.query.page){
                var x = this.$route.query.page
                this.page = parseInt(x)
            }
            this.getReview();
        },
        methods:{
            async getReview(){
                this.$http.get('/tags/analyze/'+this.$route.params.tagId+'/list')
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
                this.$router.push({ path: '/'+this.$route.params.tagId, query: {...query, page: data}})
                this.loading = true;
                if(this.$route.query.page){
                    var x = this.$route.query.page
                    this.page = parseInt(x)
                }
                this.getReview()
            },
        }
    }
</script>

<style scoped>

</style>