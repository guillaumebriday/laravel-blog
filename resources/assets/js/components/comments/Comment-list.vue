<template>
    <div>
        <comment v-for="comment in comments"
                 :key="comment.id"
                 :comment="comment"
                 :data_confirm="data_confirm"
                 @deleted="removeComment(comment)">
        </comment>

        <button v-if="endpoint" @click="retrieveComments" class="btn btn-outline-primary btn-block">
            <i v-if="isLoading" class="fa fa-spinner fa-spin fa-fw"></i>
            {{ loading_comments }}
        </button>
    </div>
</template>

<script>
export default {
  props: [
      'post_id',
      'loading_comments',
      'data_confirm'
  ],

  data() {
      return {
          comments: [],
          isLoading: false,
          endpoint: '/api/v1/posts/'+ this.post_id + '/comments/'
      }
  },

  mounted() {
    this.retrieveComments()

    if (window.Echo) {
        Echo.channel('post.' + this.post_id)
            .listen('.comment.posted', (e) => {
                this.comments.unshift(e.comment)
            });
    }
  },

  methods: {
    retrieveComments() {
        this.isLoading = true

        axios.get(this.endpoint).then(response => {
            this.comments.push(...response.data.data)
            this.isLoading = false
            this.endpoint = response.data.links.next
        });
    },

    removeComment(comment) {
        this.comments = this.comments.filter(item => {
            return item.id !== comment.id
        })
    },

    addComment(comment) {
        this.comments.unshift(comment)
    }
  }
}
</script>
