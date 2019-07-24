<h2 class="mt-2">{{ trans_choice('comments.count', $post->comments_count) }}</h2>

@include ('comments/_form')

<comment-list
    :post-id="{{ $post->id }}"
    loading-comments="@lang('comments.loading_comments')"
    data-confirm="@lang('forms.comments.delete')">
</comment-list>
