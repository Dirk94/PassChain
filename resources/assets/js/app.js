
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
import VueLocalStorage from 'vue-localstorage';
import _Auth from './core/auth.js';

window.Vue = require('vue');
window.Auth = new _Auth();

Vue.use(VueRouter);
Vue.use(VueLocalStorage), {
    name: 'ls'
};

Vue.component('navigation', require('./components/Navigation.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));

const routes = [
    { path: '', component: require('./components/pages/Welcome.vue') },
    { path: '/login', component: require('./components/pages/Login.vue') },
    { path: '/register', component: require('./components/pages/Register.vue') },

    {
        path: '/user',
        component: require('./components/pages/user/Layout.vue'),
        meta: { requiresAuth: true },
        children: [
            { path: '', component: require('./components/pages/user/Passwords.vue') },
            { path: 'settings', component: require('./components/pages/user/Settings.vue') }
        ]
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (Vue.localStorage.get('token') === null) {
            next({ path: '/login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

const app = new Vue({
    router,
    el: '#app',
    data: {
        loggedIn: false,
        name: 'default',
        email: 'default'
    },
    methods: {
        updateUserDetails() {
            this.loggedIn = (this.$localStorage.get('token') !== null);

            if (this.loggedIn) {
                this.name = this.$localStorage.get('name');
                this.email = this.$localStorage.get('email');
            } else {
                this.name = '';
                this.email = '';
            }
        }
    },
    created: function() {
        if (this.$localStorage.get('token')) {
            this.loggedIn = true;
            this.name = this.$localStorage.get('name');
            this.email = this.$localStorage.get('email');
        }
    }
});
