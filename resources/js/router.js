import VueRouter from 'vue-router'
import Home from './components/Home'
import Vue from "vue";

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    },
    routes: [
        {
            path: '/home',
            name: 'home',
            alias: '/emails',
            component: Home
        },
    ],
});

export default router;
