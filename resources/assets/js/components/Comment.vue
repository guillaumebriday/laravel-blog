<template>
    <div class="card mb-2">
        <div class="card-body">
            <div class="card-title d-flex justify-content-between">
                <h6>
                    <a :href="comment.author_url">{{ comment.author_name }}</a>
                </h6>

                <button v-if="comment.can_delete" @click="deleteComment" class="close text-danger">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <p class="card-text">{{ comment.content }}</p>
            <p class="card-text">
                <small class="text-muted">{{ comment.humanized_posted_at }}</small>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'comment',
        'data_confirm'
    ],

    methods: {
        deleteComment() {
            if (confirm(this.data_confirm)) {
                axios.delete('/api/v1/comments/' + this.comment.id)
                    .then(response => {
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

