<template>
  <div>
    <span class="count">{{ count }}</span><span class="text">{{ text }}</span>
  </div>
</template>

<script>
  export default {
    props: {
      initial_count: {
        type: Number,
        default: function (value) {
          return value >= 0 ? value : 0;
        }
      },
      text: {
        type: String
      }
    },

    data() {
      return {
        count: this.initial_count
      }
    },

    mounted() {
      Event.$on("added", comment => this.addCommentEvent(comment));
      Event.$on("removed", comment => this.removeCommentEvent(comment));
    },
    methods: {
      addCommentEvent(comment) {
        this.count++
      },
      removeCommentEvent(comment) {
        this.count > 0 && this.count--;
      }
    }
  }
</script>