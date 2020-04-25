import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import firstPage from './components/pages/firstPage';
import secondPage from './components/pages/secondPage';
import hooks from './components/basic/hooks';

const routes = [
    {
        path: '/my-new-vue-route',
        component: firstPage 
    },
    {
        path: '/my-second-page-route',
        component: secondPage
    },

    // vue hooks
    {
        path: '/hooks',
        component: hooks
    }
];

export default new Router({
    mode: 'history',
    routes
});