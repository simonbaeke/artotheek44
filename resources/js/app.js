/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
console.log('test')
console.log(process.env.MIX_BASE_URL)
window._ = require('lodash');
window.axios = require('axios');


window.Vue = require('vue');


window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//window.axios.defaults.baseURL = 'http://127.0.0.1:8001';
//window.axios.defaults.baseURL = 'http://www.artotheek44.be';
//window.axios.defaults.baseURL = 'http://192.168.1.25:81';

console.log(process.env)
//
import Vue from 'vue'
import router from './router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import {store} from './store'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

//import Vuetify from 'vuetify/lib'

Vue.use(Vuetify, {
        theme: {
            primary: '#044E7F',
            secondary: '#689F38',
            accent: '#d67c33',
            error: '#FF5252',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FFC107'

        },

    }
)
const opts = {}

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
})


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


Vue.component('app-component', require('./components/App.vue').default);
Vue.component('app-main', require('./components/SiteComponent.vue').default)
Vue.component('app-auth', require('./components/AuthDialog.vue').default)
Vue.component('app-message', require('./components/Message.vue').default)
Vue.component('app-navigation', require('./components/User/Navigation.vue').default)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

axios.get('/sanctum/csrf-cookie').then(response => {

    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify({
            theme: {
                primary: '#044E7F',
                secondary: '#689F38',
                accent: '#d67c33',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'

            }
        }),
        router,
        store,
    })
});



