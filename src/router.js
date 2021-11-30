import { createRouter, createWebHistory } from 'vue-router';

import store from './store';

import SignIn from '@/views/SignIn.vue';
import SignUp from '@/views/SignUp.vue';
import Logout from '@/views/Logout.vue';
import Home from '@/views/Home.vue';

const logoutedUserRedirect = (to, from, next) => {
    if (store.getters.userAuthorized) {
        next();
    } else {
        next('/sign-in');
    }
};

const loginedUserRedirect = (to, from, next) => {
    console.log('redirect?');
    if (store.getters.userAuthorized) {
        next('/');
    } else {
        next();
    }
};

const routes = [
    { path: '/sign-in', component: SignIn, beforeEnter: loginedUserRedirect },
    { path: '/sign-up', component: SignUp, beforeEnter: loginedUserRedirect },
    { path: '/logout',  component: Logout },
    { path: '/', component: Home, beforeEnter: logoutedUserRedirect }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

  
export default router;
