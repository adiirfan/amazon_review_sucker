<template>
    <div v-if="data">
        <vue-tags-input
                v-model="tag"
                :tags="tags[0]"
                :autocomplete-items="filteredItems"
                @tags-changed="newTags => tags[0] = newTags"
                @before-adding-tag="store"
                @before-deleting-tag="deleting"
        />
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';
    export default {
        name: "reviewTags",
        data() {
            return {
                tag: '',
                tags:[
                    []
                ],
                idTags:'',
                data:false,
                autocompleteItems:[],
            };
        },
        components: {
            VueTagsInput,
        },
        mounted(){
            this.getTags();
            this.autocompleteItems = this.tagList;
        },
        computed: {
            filteredItems() {
                return this.autocompleteItems.filter(i => {
                    return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
                });
            },
        },
        methods:{
            deleting(obj){
                this.$http.post('/tagsreview/'+obj.tag.id+'/delete')
                obj.deleteTag();
            },
            store(obj){
                this.$http.post('/tags/'+this.id+'/add', {
                    tagsName: obj.tag.text,
                }).then(response => {
                    obj.tag.id = response.data.data.id;
                    obj.addTag();
                }).catch(error => {
                    if(error.response.status === 401){
                        window.location.href = '/login'
                    }else{
                        window.location.href = '/'
                    }
                })
            },
            getTags(){
                this.$http.get('/tags/review/'+this.id)
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
                    .finally(() => this.pushTags())
            },
            pushTags(){
                if(this.data.length > 0) {
                    var i;
                    for (i = 0; i < this.data.length; i++) {
                        var data = {
                            "text": this.data[i].tags_review.tagsName,
                            "tiClasses": ["ti-valid"],
                            "id":this.data[i].id
                        }
                        this.tags[0].push(data)
                    }
                }
            },
        },
        props:[
            'id',
            'tagList'
        ],
    }
</script>

<style scoped>

</style>