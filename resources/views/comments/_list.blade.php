<h2 class="mt-2">{{ trans_choice('comments.count', $post->comments_count) }}</h2>

@include ('comments/_form')

<comment-list
    post_id="{{ $post->id }}"
    loading_comments="{{ __('comments.loading_comments') }}">
</comment-list>
