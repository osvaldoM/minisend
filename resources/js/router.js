import VueRouter from 'vue-router'
import Home from './components/Home'
import Vue from "vue";
import nprogress from 'nprogress'

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

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        nprogress.start()
    }
    next()
})

router.afterEach((to, from) => {
    nprogress.done()
})

export default router;
