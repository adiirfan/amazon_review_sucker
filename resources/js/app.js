require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import StarRating from 'vue-star-rating'


Vue.use(VueRouter)


import App from './views/App'
import SummaryPage from './views/summaryPage'
import Home from './views/Home'
import Login from './views/login'
import analyzeDetail from './views/analyzeDetail'
import Callback from './views/callback'
import analyze from './views/analyze'
import axios from 'axios'
import register from './views/register'

var token = localStorage.getItem('token')
const base = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        Authorization: 'Bearer '+ token
    }
})

Vue.prototype.$http = base

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'guest:login',
            component: Login
        },
        {
            path: '/register',
            name: 'guest:register',
            component: register
        },
        {
            path: '/auth/callback',
            name: 'authToken',
            component: Callback,
        },
        {
            path: '/analyze',
            name: 'analyze',
            component: analyze,
        },
        {
            path: '/analyze/:tagId',
            name: 'analyzeDetail',
            component: analyzeDetail,
        },
        {
            path: '/:productId',
            name: 'summaryPage',
            component: SummaryPage,
        },
    ],
});
Vue.component('star-rating', StarRating);
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});