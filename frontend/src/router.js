import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Main from './Main.vue';
import Login from './views/Login.vue';

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/main',
      name: 'main',
      component: Main,
      children: [
        {
          path: '/about',
          name: 'about',
          component: () => import('./views/About.vue')
        },
        {
          path: '/contacts',
          name: 'contacts',
          component: () => import('./views/Contacts.vue')
        }
      ]
    }
  ]
})
