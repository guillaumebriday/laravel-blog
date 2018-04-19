window.Vue = require('vue');

Vue.config.productionTip = false;

Vue.component('comment', require('./components/comments/Comment.vue'));
Vue.component('comment-list', require('./components/comments/Comment-list.vue'));
Vue.component('comment-form', require('./components/comments/Comment-form.vue'));
Vue.component('comment-count', require('./components/comments/Comment-count.vue'));

Vue.component('like', require('./components/Like.vue'));

window.Event = new Vue();

const app = new Vue({
  el: '#app',

  mounted() {
    $('[data-confirm]').on('click', function () {
      return confirm($(this).data('confirm'))
    })
  }
});
