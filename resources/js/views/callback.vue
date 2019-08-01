<template>
    
</template>

<script>
    export default {
        name: "callback",
        data(){
            return{
                'token': this.$route.query.token
            }
        },
        mounted() {
            if(this.$route.query.token){
                localStorage.setItem('token',this.$route.query.token)
                window.location.href = '/'
            }else{
                window.location.href = '/login'
            }
        }
    }
</script>

<style scoped>

</style>