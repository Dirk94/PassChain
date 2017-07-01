
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
import VueLocalStorage from 'vue-localstorage';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(VueLocalStorage), {
    name: 'ls'
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navigation', require('./components/Navigation.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));

const routes = [
    { path: '', component: require('./components/pages/Welcome.vue') },
    { path: '/login', component: require('./components/pages/Login.vue') },
    { path: '/register', component: require('./components/pages/Register.vue') },
    { path: '/account', component: require('./components/pages/account/Home.vue') }
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

const app = new Vue({
    router,
    el: '#app',
    data: {
        loggedIn: false,
        name: '',
        email: ''
    },
    methods: {
        updateUserDetails() {
            if (this.$localStorage.get('token')) {
                this.loggedIn = true;
                this.name = this.$localStorage.get('name');
                this.email = this.$localStorage.get('email');
            } else {
                this.loggedIn = false;
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
