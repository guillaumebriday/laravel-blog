<template>
  <div>
    <comment
      v-for="comment in comments"
      :key="comment.id"
      :comment="comment"
      :data-confirm="dataConfirm"
      @deleted="removeComment(comment)"
    />

    <button
      v-if="endpoint"
      :disabled="isLoading"
      class="btn btn-outline-primary btn-block"
      @click="retrieveComments"
    >
      <i
        v-if="isLoading"
        class="fa fa-spinner fa-spin fa-fw"
      />
      {{ loadingComments }}
    </button>
  </div>
</template>

<script>
import axios from 'axios'
import Comment from './Comment'

export default {
  components: { Comment },

  props: {
    postId: {
      type: Number,
      required: true
    },

    loadingComments: {
      type: String,
      required: true
    },

    dataConfirm: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      comments: [],
      isLoading: false,
      endpoint: `/api/v1/posts/${this.postId}/comments/`
    }
  },

  mounted () {
    this.retrieveComments()

    Event.$on('added', comment => this.addComment(comment))

    window.Echo.channel(`post.${this.postId}`)
      .listen('.comment.posted', e => this.addComment(e.comment))
  },

  methods: {
    retrieveComments () {
      this.isLoading = true

      axios.get(this.endpoint).then(({ data }) => {
        this.comments.push(...data.data)
        this.isLoading = false
        this.endpoint = data.links.next
      })
    },

    addComment (comment) {
      this.comments.unshift(comment)
    },

    removeComment ({ id }) {
      this.comments.splice(this.comments.findIndex(comment => comment.id === id), 1)
    }
  }
}
</script>
