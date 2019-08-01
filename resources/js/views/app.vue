<template>
    <div>
        <navbar v-if="$route.name !== 'login'" />
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import navbar from '../components/navbar.vue'
    export default {
        components: {
            navbar
        }
    }
</script>