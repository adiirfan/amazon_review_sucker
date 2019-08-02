<template>
    <header>
        <div class="container">
            <nav class="navbar navbar-default" style="background-color:white">
                <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                        </a>
                        <ul class="nav navbar-nav">
                            <li :class="$route.name === 'home' ? 'active' : ''">
                                <router-link :to="{ name: 'home' }">Home</router-link>
                            </li>
                            <li :class="$route.name === 'analyze' || $route.name === 'analyzeDetail'  ? 'active' : ''">
                                <router-link :to="{ name: 'analyze' }">Analyze</router-link>
                            </li>
                        </ul>
                        <div class="navbar-right">
                            <a v-on:click="logout" class="btn btn-success navbar-btn">
                                Log Out
                            </a>
                        </div>
                </div>
            </nav>
        </div>
    </header>
</template>
<script>
    export default {
        name: "navbar",
        methods:{
            logout(){
                localStorage.removeItem('token');
                window.location.href = '/login'
            }
        }
    }
</script>

<style scoped>
    .navbar{
        margin-bottom: 0px;
    }

</style>