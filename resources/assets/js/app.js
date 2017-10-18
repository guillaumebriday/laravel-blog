require('./bootstrap');

window.Vue = require('vue');

Vue.component('comment', require('./components/Comment.vue'));
Vue.component('comment-list', require('./components/Comment-list.vue'));
Vue.component('comment-form', require('./components/Comment-form.vue'));

const app = new Vue({
    el: '#app',

    mounted() {
        $('[data-confirm]').on('click', function() {
            return confirm($(this).data('confirm'))
        })
    }
});
