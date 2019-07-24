<template>
  <span>
    <i
      class="fa ml-2"
      :class="[isLiked ? 'fa-heart text-danger' : 'fa-heart-o']"
      style="user-select: none;"
      :style="[isLoggedIn ? { cursor: 'pointer' } : '']"
      aria-hidden="true"
      @click="toggleLike"
    /> {{ count }}
  </span>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    liked: {
      type: Boolean,
      required: true
    },

    likesCount: {
      type: Number,
      required: true
    },

    itemType: {
      type: String,
      required: true
    },

    itemId: {
      type: Number,
      required: true
    },

    loggedIn: {
      type: Boolean,
      required: true
    }
  },

  data () {
    return {
      isLiked: this.liked,
      isLoggedIn: this.loggedIn,
      count: this.likesCount,
      endpoint: `/api/v1/${this.itemType}/${this.itemId}/likes`,
      isLoading: false
    }
  },

  methods: {
    toggleLike () {
      if (this.isLoading || !this.isLoggedIn) {
        return
      }

      if (this.isLiked) {
        return this.dislike()
      }

      this.like()
    },

    like () {
      this.isLoading = true

      axios
        .post(this.endpoint)
        .then(response => {
          this.isLoading = false
          this.isLiked = true
          this.count++
        })
        .catch(() => {
          this.isLoading = false
        })
    },

    dislike () {
      this.isLoading = true

      axios
        .delete(this.endpoint)
        .then(response => {
          this.isLoading = false
          this.isLiked = false
          this.count--
        })
        .catch(() => {
          this.isLoading = false
        })
    }
  }
}
</script>
