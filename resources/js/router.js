import VueRouter from 'vue-router';
import Vue from 'vue';
import nprogress from 'nprogress';
import Home from './components/TheHome';
import EmailsToRecipient from './components/EmailsToRecipient';
import EmailDetails from './components/EmailDetails';
import PageNotFound from './components/PageNotFound';
import Help from './components/Help';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }
    return { x: 0, y: 0 };
  },
  routes: [
    {
      path: '/home',
      name: 'home',
      alias: '/',
      component: Home,
    },
    {
      path: '/emails/to/:recipient',
      name: 'emailsTo',
      component: EmailsToRecipient,
      props: true,
    }, {
      path: '/emails/:id',
      name: 'emailDetails',
      component: EmailDetails,
      props: true,
    },
    {
      path: '/help',
      component: Help,
    },
    {
      path: '*',
      component: PageNotFound,
    },
  ],
});

router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (to.name) {
    nprogress.start();
  }
  next();
});

router.afterEach((to, from) => {
  nprogress.done();
});

export default router;
