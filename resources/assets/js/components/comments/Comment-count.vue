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
    },
    methods: {
      addCommentEvent(comment) {
        this.count++
      }
    }
  }
</script>