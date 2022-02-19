import Vue from 'vue';
// window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Store from '../components/store/dashboard/index.vue';


const routes = [
    {
        path: '/store/:store_id',
        name: 'storeDashboard',
        component: Store,
        props: true,
    },
]

const router = new VueRouter({
    routes,
    // hashbang:false,
    mode:'history'
})

export default router;
