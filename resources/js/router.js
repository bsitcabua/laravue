import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import firstPage from './components/pages/firstPage';
import secondPage from './components/pages/secondPage';
import hooks from './components/basic/hooks';
import methods from './components/basic/methods';

// admin project pages 
import home from './components/pages/home';
import tags from './admin/pages/tags';
import category from './admin/pages/category';

const routes = [
    // Projects routes...
    {
        path: '/', 
        component: home, 
       
    },
    {
        path: '/tags', 
        component: tags, 
       
    },
    {
        path: '/category', 
        component: category, 
       
    },

    // Basics tutorials routes
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
    },
    // vue methods
    {
        path: '/methods',
        component: methods
    },
];

export default new Router({
    mode: 'history',
    routes
});