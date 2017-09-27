
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//require('jquery-ui/ui/widgets/dialog.js');
//require('bootstrap');
//require('bootstrap/dist/css/bootstrap.min.css');

window.Vue = require('vue');
Vue.config.devtools = false;
Vue.config.productionTip = false;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));

Vue.component('data-contract-create', require('./components/DataContractCreate.vue'));

const app = new Vue({
    el: '#app'
});
