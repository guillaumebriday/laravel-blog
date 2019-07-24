<template>
  <div class="card mb-2">
    <div class="card-body">
      <div class="card-title d-flex justify-content-between">
        <h6>
          <a :href="comment.author_url">{{ comment.author_name }}</a>
        </h6>

        <button
          v-if="comment.can_delete"
          class="close text-danger"
          @click="deleteComment"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <p class="card-text">
        {{ comment.content }}
      </p>
      <p class="card-text">
        <small class="text-muted">{{ comment.humanized_posted_at }}</small>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    comment: {
      type: Object,
      required: true
    },

    dataConfirm: {
      type: String,
      required: true
    }
  },

  methods: {
    deleteComment () {
      if (confirm(this.dataConfirm)) {
        axios
          .delete(`/api/v1/comments/${this.comment.id}`)
          .then(() => {
            this.$emit('deleted', this)
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  }
}
</script>
