/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue'
import vuetify from './plugins/vuetify.js';

// Axios 
import axios from 'axios'
import VueAxios from 'vue-axios'
import User from './Helpers/User'

Vue.use(vuetify);
Vue.use(VueAxios, axios)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-home', require('./components/AppHome.vue').default);
Vue.component('base-button', require('./layout/BaseButton.vue').default);
// use User class
window.User = User;
console.log(User.checkIfLoggedIn());
import router from './router/router.js';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 new Vue({
    vuetify,
    router,
  }).$mount('#app')