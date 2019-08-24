
require('./bootstrap');
window.Vue = require('vue');


import {Form, HasError, AlertError } from 'vform';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
window.Swal=Swal;
window.Fire=new Vue();

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast=Toast;

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '10px'
})

Window.Form= Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'

Vue.use(VueRouter);


let routes = [
    { path: '/developer', component: require('./components/developer.vue').default },
    { path: '/dashboard', component: require('./components/dashboard.vue').default },
    { path: '/permissionFor', component: require('./components/permission_for.vue').default },
    { path: '/permission', component: require('./components/permission.vue').default },
    { path: '/role', component: require('./components/role.vue').default },
    { path: '/admin', component: require('./components/admin.vue').default },
    { path: '/seo', component: require('./components/seo.vue').default },
    { path: '/category', component: require('./components/category.vue').default },
    { path: '/carousel', component: require('./components/carousel.vue').default },
    { path: '/tags', component: require('./components/tags.vue').default },
    { path: '/post', component: require('./components/post.vue').default },
];


const router = new VueRouter({
    mode: 'history',
    routes
});



Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    router,
    el: '#app'

});
