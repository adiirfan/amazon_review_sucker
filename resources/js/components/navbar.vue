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
                            <li :class="$route.name === 'hello' ? 'active' : ''">
                                <router-link :to="{ name: 'hello' }">Hello World</router-link>
                            </li>
                        </ul>
                        <div class="navbar-right">
                            <a href="/getting-started/#download" class="btn btn-success navbar-btn">
                                Download
                            </a>
                        </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
    export default {
        name: "navbar"
    }
</script>

<style scoped>
    .navbar{
        margin-bottom: 0px;
    }

</style>