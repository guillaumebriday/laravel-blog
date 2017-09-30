<template>
    <div>
        <comment v-for="comment in comments"
                 :key="comment.id"
                 :comment="comment">
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
      'loading_comments'
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
  },

  methods: {
    retrieveComments() {
        this.isLoading = true

        axios.get(this.endpoint).then(response => {
            this.comments.push(...response.data.data)
            this.isLoading = false
            this.endpoint = response.data.links.next
        });
    }
  }
}
</script>
