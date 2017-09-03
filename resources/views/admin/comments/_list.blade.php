<table class="table table-striped">
    <caption>{{ trans_choice('comments.count', $comments->total()) }}</caption>
    <thead>
        <tr>
            <th>{{ __('comments.attributes.content') }}</th>
            <th>{{ __('comments.attributes.post') }}</th>
            <th>{{ __('comments.attributes.author') }}</th>
            <th>{{ __('comments.attributes.posted_at') }}</th>
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
