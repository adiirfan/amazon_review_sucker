<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Sign Up</h3>
                        <form class="form-signin">
                            <div class="form-label-group">
                                <label for="inputEmail">Email address</label>
                                <input type="email" v-model="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            </div>
                            <div class="form-label-group">
                                <label for="inputName">Name</label>
                                <input type="text" v-model="name" id="inputName" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-label-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" v-model="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            </div>
                            <button class="btn btn-primary btn-block text-uppercase m-y-2" v-on:click="register">Sign up</button>
                            <hr class="my-4">
                            <a href="/login" class="btn btn-primary btn-block text-uppercase m-y-2" >Sign In</a>
                            <a href="/login/facebook" class="btn btn-facebook btn-block text-uppercase" type="submit"> Register with Facebook</a>
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
                name:'',
                error:0
            }
        },
        methods:{
            async register(){
                await this.$http.post('/register', {
                    email:this.email,
                    name:this.name,
                    password:this.password,
                    c_password:this.password
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