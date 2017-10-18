<h2 class="mt-2">{{ trans_choice('comments.count', $post->comments_count) }}</h2>

@include ('comments/_form')

<comment-list
    post_id="{{ $post->id }}"
    loading_comments="@lang('comments.loading_comments')"
    data_confirm="@lang('forms.comments.delete')"
    placeholder="@lang('comments.placeholder.content')"
    button="@lang('comments.comment')"
    auth="{{ Auth::check() }}">
</comment-list>
