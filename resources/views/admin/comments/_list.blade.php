<table class="table table-striped table-sm">
    <caption>{{ trans_choice('comments.count', $comments->total()) }}</caption>
    <thead>
        <tr>
            <th>@lang('comments.attributes.content')</th>
            <th>@lang('comments.attributes.post')</th>
            <th>@lang('comments.attributes.author')</th>
            <th>@lang('comments.attributes.posted_at')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $comment)
            <tr>
                <th>{{ link_to_route('admin.comments.edit', $comment->content, $comment) }}</th>
                <td>{{ link_to_route('posts.show', $comment->post->title, $comment->post) }}</td>
                <td>{{ link_to_route('users.show', $comment->author->fullname, $comment->author) }}</td>
                <td>{{ humanize_date($comment->posted_at, 'd/m/Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $comments->links() }}
</div>
