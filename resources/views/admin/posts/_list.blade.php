<table class="table table-striped">
    <caption>{{ trans_choice('posts.count', $posts->total()) }}</caption>
    <thead>
        <tr>
            <th>{{ __('posts.attributes.title') }}</th>
            <th>{{ __('posts.attributes.author') }}</th>
            <th>{{ __('posts.attributes.posted_at') }}</th>
            <th><i class="fa fa-comments" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <th>{{ link_to_route('admin.posts.edit', $post->title, $post) }}</th>
                <td>{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</td>
                <td>{{ humanize_date($post->posted_at, 'd/m/Y H:i:s') }}</td>
                <td><span class="badge">{{ $post->comments_count }}</span></td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">
    {{ $posts->links() }}
</div>
