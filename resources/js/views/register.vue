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
                                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <input type="email" id="inputName" class="form-control" placeholder="Email address" required autofocus>
                                <label for="inputName">Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>
                            <button class="btn btn-primary btn-block text-uppercase" type="submit">Sign up</button>
                            <hr class="my-4">
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
        name: "login"
    }
</script>

<style scoped>
    .container{
        margin: 5% 0;
    }
</style>