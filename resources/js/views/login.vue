<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Sign In</h3>
                        <form class="form-signin">
                            <div class="form-label-group">
                                <label for="inputEmail">Email address</label>
                                <input type="email" v-model="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus :class="error === 1 ? 'has-error' : ''">
                            </div>

                            <div class="form-label-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" v-model="password" id="inputPassword" class="form-control" placeholder="Password" required :class="error === 1 ? 'has-error' : ''">
                            </div>
                            <a class="btn btn-primary btn-block text-uppercase m-y-2" v-on:click="login()">Sign in</a>
                            <hr class="my-4">
                            <a href="/register" class="btn btn-primary btn-block text-uppercase m-y-2" >Sign Up</a>
                            <a href="/login/facebook" class="btn btn-facebook btn-block text-uppercase" type="submit"> Sign in with Facebook</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login",
        data(){
            return{
                email:'',
                password:'',
                error:0
            }
        },
        methods:{
            async login(){
                await this.$http.post('/login', {
                    email:this.email,
                    password:this.password,
                })
                    .then(response => {
                        localStorage.setItem('token',response.data.success.token)
                        window.location.href = '/'
                    })
                    .catch(error => {
                        this.error = 1;
                        this.errorMsg = error.response.data.errors
                    })
                    .finally(() => this.loading = false)
            }
        }

    }
</script>

<style scoped>
    .container{
        margin: 5% 0;
    }
</style>