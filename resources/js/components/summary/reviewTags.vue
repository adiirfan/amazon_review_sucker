<template>
    <div>
        <vue-tags-input
                :v-model="tag"
                :tags="tags[0]"
                value="add Tags"
                @tags-changed="newTags => tags[0] = newTags && store(n,newTags) "
        />
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';
    export default {
        name: "reviewTags",
        data() {
            return {
                tag: [],
            };
        },
        components: {
            VueTagsInput,
        },
        methods:{
            store(n,newTags){

            }
        },
        props:[
            'tags',
        ]
    }
</script>

<style scoped>

</style>