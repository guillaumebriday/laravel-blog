<template>
  <div>
    <div class="form-group">
      <textarea
        v-model="content"
        class="form-control"
        :class="{ 'is-invalid' : errors['content'] }"
        :placeholder="placeholder"
      />

      <span
        v-if="errors['content']"
        class="invalid-feedback"
      >{{ errors['content'][0] }}</span>
    </div>

    <div class="form-group text-right">
      <button
        class="btn btn-primary"
        :disabled="isDisabled"
        @click="sendComment"
      >
        <i
          v-if="isLoading"
          class="fa fa-spinner fa-spin fa-fw"
        />
        {{ button }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    postId: {
      type: Number,
      required: true
    },

    placeholder: {
      type: String,
      default: null
    },

    button: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      content: '',
      isLoading: false,
      errors: []
    }
  },

  computed: {
    isDisabled () {
      return this.isLoading || this.content.length === 0
    }
  },

  methods: {
    sendComment () {
      this.isLoading = true

      axios
        .post(`/api/v1/posts/${this.postId}/comments`, {
          content: this.content
        })
        .then(({ data }) => {
          Event.$emit('added', data.data)

          this.content = ''
          this.isLoading = false
          this.errors = []
        })
        .catch(error => {
          this.isLoading = false
          this.errors = error.response.data.errors
        })
    }
  }
}
</script>
