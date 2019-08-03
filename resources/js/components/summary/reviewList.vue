<template>
    <div class="row" v-if="!loading">
        <div class="col-md-12">
            <h3 class="text-xs-center text-md-left">Review List</h3>
        </div>
        <div class="col-md-12 m-y-1 " v-for="(review,key) in data" v-bind:key="key">
            <div class="card">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-body">
                            <a :href="review.reviewUrl" target="_blank"><h4 class="panel-title">{{review.title}}</h4> </a>
                            <p>{{review.body}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <span>
                                <star-rating :star-size=20 read-only :rating=review.rating :show-rating=false ></star-rating>
                            </span>
                            <a :href="review.authorUrl" target="_blank"> <span>
                                By {{review.author}} <br>
                            </span> </a>
                            <span>
                                {{review.reviewDate}}<br>
                            </span>
                            <span>
                                {{review.comment}} Comments <br>
                            </span>
                            <span>
                                 {{helfulvotes(review.votes)}} Helpful Votes <br>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted" v-if="tagList">
                    <review-tags :id="review.id" :tagList="tagList"></review-tags>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';
    import reviewTags from './reviewTags';
    export default {
        name: "reviewList",
        data() {
            return {
                tag: [],
                page: 1,
                star:"",
                verif:"",
                tagList:false,

            };
        },
        components: {
            VueTagsInput,
            reviewTags,
        },
        mounted(){
            this.getTagList();
        },
        methods:{
            async getTagList(){
                await this.$http.get('/tags')
                    .then(response => {
                        this.tagList = response.data
                    })
                    .catch(error => {
                        if(error.response.status === 401){
                            window.location.href = '/login'
                        }else{
                            //window.location.href = '/'
                        }
                    })
            },
            helfulvotes(data){
                if(data === null){
                    return 0;
                }
                return data
            }
        },
        props:[
            'data',
            'loading'
        ]
    }
</script>

<style scoped>

</style>