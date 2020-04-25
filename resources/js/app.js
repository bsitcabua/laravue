require('./bootstrap');

// Load the vue lib
window.Vue = require('vue');

// Load the main app component
Vue.component('mainapp', require('./components/mainapp.vue').default);

const app = new Vue({
    el: '#app'
});