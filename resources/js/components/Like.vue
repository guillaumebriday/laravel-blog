<template>
  <span>
    <i class="fa ml-2"
       :class="[isLiked ? 'fa-heart text-danger' : 'fa-heart-o']"
       @click="toggleLike"
       style="user-select: none;"
       :style="[isLoggedIn ? { cursor: 'pointer' } : '']"
       aria-hidden="true"></i> {{ count }}
  </span>
</template>

<script>
import axios from 'axios'

export default {
  props: ["liked", "likes_count", "item_type", "item_id", "logged_in"],

  data() {
    return {
      isLiked: this.liked,
      isLoggedIn: this.logged_in,
      count: parseInt(this.likes_count) || 0,
      endpoint: "/api/v1/" + this.item_type + "/" + this.item_id + "/likes",
      isLoading: false
    }
  },

  methods: {
    toggleLike() {
      if (this.isLoading || !this.isLoggedIn) {
        return
      }

      if (this.isLiked) {
        return this.dislike()
      }

      this.like()
    },

    like() {
      this.isLoading = true

      axios
        .post(this.endpoint)
        .then(response => {
          this.isLoading = false
          this.isLiked = true
          this.count++
        })
        .catch(error => {
          this.isLoading = false
        })
    },

    dislike() {
      this.isLoading = true

      axios
        .delete(this.endpoint)
        .then(response => {
          this.isLoading = false
          this.isLiked = false
          this.count--
        })
        .catch(error => {
          this.isLoading = false
        })
    }
  }
}
</script>

