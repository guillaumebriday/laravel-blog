<h2 class="mt-2">{{ trans_choice('comments.count', $post->comments_count) }}</h2>

@include ('comments/_form')

<comment-list
    post_id="{{ $post->id }}"
    loading_comments="{{ __('comments.loading_comments') }}"
    data_confirm="{{ __('forms.comments.delete') }}"
    placeholder="{{ __('comments.placeholder.content') }}"
    button="{{ __('comments.comment') }}"
    auth="{{ Auth::check() }}">
</comment-list>
