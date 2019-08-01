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
                                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Remember password</label>
                            </div>
                            <button class="btn btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                            <hr class="my-4">
                            <button class="btn btn-google btn-block text-uppercase" type="submit"> Sign in with Google</button>
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
        name: "login"
    }
</script>

<style scoped>
    .container{
        margin: 5% 0;
    }
</style>