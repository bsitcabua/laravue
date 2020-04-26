require('./bootstrap');
// Load the vue libs
window.Vue = require('vue');
import router from './router';
Vue.use(require('vue-moment'));
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
import common from './common';
Vue.mixin(common);

// Load the main app component
Vue.component('mainapp', require('./components/mainapp.vue').default);
const app = new Vue({
    el: '#app',
    router
});