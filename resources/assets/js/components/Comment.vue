<template>
    <div class="card mb-2">
        <div class="card-body">
            <div class="card-title d-flex justify-content-between">
                <h6>
                    <a :href="comment.author_url">{{ comment.author_name }}</a>
                </h6>
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
    props: ['comment']
}
</script>

