/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import moment from 'moment';

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.filter('formatDateTime', function(value) {
    if (value) {
        return moment(String(value)).format('DD MMM YYYY hh:mm')
    }
});
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD MMM YYYY')
    }
});

Vue.component('loan-form', require('./components/template/loan-form.vue').default);
Vue.component('loan-index-page', require('./pages/loan/index.vue').default);
Vue.component('loan-create-page', require('./pages/loan/create.vue').default);
Vue.component('loan-edit-page', require('./pages/loan/edit.vue').default);
Vue.component('loan-show-page', require('./pages/loan/show.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
