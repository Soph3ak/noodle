/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;

import VueCurrencyInput from 'vue-currency-input'
Vue.use(VueCurrencyInput)


import 'vue-loading-overlay/dist/vue-loading.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'))
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('dashboard', require('./components/Dashboard').default);
Vue.component('category', require('./components/Category.vue').default);
Vue.component('seat-table', require('./components/SeatTable.vue').default);
Vue.component('shop', require('./components/Shop').default);
Vue.component('customer', require('./components/Customer.vue').default);
Vue.component('report', require('./components/Report').default);
Vue.component('product', require('./components/Product').default);
Vue.component('promotion', require('./components/Promotion').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('sell', require('./components/Sell.vue').default);
Vue.component('invoice1', require('./components/Invoice1').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
