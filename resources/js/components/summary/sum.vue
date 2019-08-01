<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-xs-center text-md-left">Review Summary</h3>
                </div>
                <div class="col-md-12 m-y-3">
                    <div class="card">
                        <div class="card-body" v-if="sumData">
                            <h2 class="panel-title">{{product.ASIN}}</h2>
                            <!--p>213123123</p!-->
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Average Star : {{avg}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p >Total Review : {{sumData.totalReview}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Verified Review : {{sumData.verifiedReview}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Unverified Review : {{sumData.unverifiedReview}}</p>
                                </div>
                            </div>
                            <div class="row m-y-1">
                                <div class="col-md-3"  v-for="n in 5">
                                    <star-rating :star-size=15 read-only :rating="6 - n" :show-rating=false ></star-rating>
                                    <p style="font-size:0.9em;" >{{sumData.star[n-1]}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-xs-center text-md-left">Filter</h3>
                </div>
                <div class="col-md-12 m-y-3">
                    <div class="card">
                        <div class="card-body">
                            <label>Filter by Star</label><br>
                            <span v-for="n in 5">
                                <button v-if="check(6-n)" class="tw-checkbox-button checked m-x-2"
                                        v-on:click="removeStarFilter(6 - n)">
                                    <span class="tw-checkbox-check glyphicon glyphicon-ok">
                                    </span>
                                </button>
                                <button v-else-if="!check(6-n)" class="tw-checkbox-button  m-x-2"
                                        v-on:click="addStarFilter(6 - n)">
                                    <span class="tw-checkbox-check glyphicon glyphicon-ok">
                                    </span>
                                </button>
                                <span>{{6-n}}</span>
                            </span>
                        </div>
                        <div class="card-body">
                            <label >Filter by Review Type</label><br>
                            <button class="tw-radio-button m-y-1"
                                    :class="verif === '1' ? 'checked' : ''"
                                    v-on:click="verifFilter('1')">
                                <span class="tw-radio-check"></span>
                            </button>
                            <span>verified</span><br>
                            <button class="tw-radio-button" :class="verif === '0' ? 'checked' : ''"
                                    v-on:click="verifFilter('0')">
                                <span class="tw-radio-check"></span>
                            </button>
                            <span>unverified</span><br>
                            <a :href="'/'+$route.params.productId+'?star='+filterStar+'&verif='+verif"
                               type="button" class="btn btn-primary btn-sm m-y-2">Add Filter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sum",
        data(){
            return{
                avg:0,
                sumData:false,
                loading:true,
                filterStar:[],
                verif:"",
            }
        },
        props:[
            'product'
        ],
        mounted(){
            if(this.$route.query.verif){
                this.verif = this.$route.query.verif
            }
            if(this.$route.query.star){
                this.filterStar = this.$route.query.star.split(',').map(el => {
                    return parseInt(el, 10);
                });
            }
            this.getAvg()
            this.total()
        },
        methods:{
            async getAvg(){
                await this.$http.get('/product/'+this.product.ASIN+'/avg')
                    .then(response => {
                        this.avg = response.data.avg
                    })
                    .catch(error => {
                        console.log(error)

                    })
                    .finally(() => this.loading = false)
            },
            total(){
                this.$http.get('/product/'+this.product.ASIN+'/total')
                    .then(response => {
                        this.sumData = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false )
            },
            addStarFilter(data){
                this.filterStar.push(data)
                console.log(this.filterStar)
            },
            check(data){
                let isInArray = this.filterStar.includes(data);
                return isInArray;
            },
            removeStarFilter(data){
                for( var i = 0; i < this.filterStar.length; i++){
                    if ( this.filterStar[i] === data) {
                        this.filterStar.splice(i, 1);
                    }
                }
            },
            verifFilter(data){
                this.verif = data;
            }
        }
    }
</script>

<style scoped>

</style>