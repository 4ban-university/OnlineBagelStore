require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

import App from './components/App.vue';
import Home from './components/Home.vue';
import About from './components/About.vue';
import Contacts from './components/Contacts.vue';
import Login from './components/Login.vue';

window.Vue.use(VueRouter);

import BootstrapVue from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);

const routes = [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/about',
      name: 'about',
      component: About
    },
    {
      path: '/contacts',
      name: 'contacts',
      component: Contacts
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    }
];

const router = new VueRouter({ routes });

/*Vue.component('about', require('./components/About.vue'));
Vue.component('contacts', require('./components/Contacts.vue'));
Vue.component('home', require('./components/Home.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('menu', require('./components/Menu.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('order', require('./components/Order.vue'));*/

new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
