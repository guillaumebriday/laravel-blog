<h2 class="mt-2">
    <comment-count :initial_count="{{ $post->comments_count }}" text="{{ trans_choice('comments.count', $post->comments_count) }}"></comment-count>
</h2>
@include ('comments/_form')

<comment-list
    post_id="{{ $post->id }}"
    loading_comments="@lang('comments.loading_comments')"
    data_confirm="@lang('forms.comments.delete')">
</comment-list>
