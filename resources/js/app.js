require('./bootstrap');
// Load the vue libs
window.Vue = require('vue');
import router from './router';

// Load the main app component
Vue.component('mainapp', require('./components/mainapp.vue').default);

const app = new Vue({
    el: '#app',
    router
});