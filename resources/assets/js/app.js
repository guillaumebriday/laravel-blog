require('./bootstrap');

window.Vue = require('vue');

require('./delete-confirmation.js');

Vue.component('comment', require('./components/Comment.vue'));
Vue.component('comment-list', require('./components/Comment-list.vue'));

const app = new Vue({
    el: '#app'
});
