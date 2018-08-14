import CommentForm from './components/comments/CommentForm.vue'
import CommentList from './components/comments/CommentList.vue'
import Like from './components/Like.vue'
import Vue from 'vue'

Vue.config.productionTip = false

window.Event = new Vue()

new Vue({
  el: '#app',

  components: {
    CommentForm,
    CommentList,
    Like
  },

  mounted() {
    $('[data-confirm]').on('click', function () {
      return confirm($(this).data('confirm'))
    })
  }
})
