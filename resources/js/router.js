import VueRouter from 'vue-router'
import Home from './components/TheHome'
import Vue from "vue";
import nprogress from 'nprogress'
import EmailsToRecipient from "./components/EmailsToRecipient";

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
            alias: '/',
            component: Home
        },
        {
            path: '/emails/to/:recipient',
            name: 'emailsTo',
            component: EmailsToRecipient,
            props: true
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
