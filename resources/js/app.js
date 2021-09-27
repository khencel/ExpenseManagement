/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.token = document.getElementsByName("user-token")[0].content;
import Form from 'vform'
import Notifications from 'vue-notification';

window.Vue = require('vue').default;
window.Form = Form;

Vue.use(Notifications)
Vue.use(require('vue-moment'));

Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('change-password', require('./components/ChangePassword.vue').default);

require('./components/user-management/Registration');
require('./components/expense-management/Registration');

const app = new Vue({
    el: '#app',
});
