<table class="table table-striped table-sm table-responsive-md">
    <caption>{{ trans_choice('posts.count', $posts->total()) }}</caption>
    <thead>
        <tr>
            <th>@lang('posts.attributes.title')</th>
            <th>@lang('posts.attributes.author')</th>
            <th>@lang('posts.attributes.posted_at')</th>
            <th><i class="fa fa-comments" aria-hidden="true"></i></th>
            <th><i class="fa fa-heart" aria-hidden="true"></i></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ link_to_route('admin.posts.edit', $post->title, $post) }}</td>
                <td>{{ link_to_route('admin.users.edit', $post->author->fullname, $post->author) }}</td>
                <td>{{ humanize_date($post->posted_at, 'd/m/Y H:i:s') }}</td>
                <td><span class="badge badge-pill badge-secondary">{{ $post->comments_count }}</span></td>
                <td><span class="badge badge-pill badge-secondary">{{ $post->likes_count }}</span></td>
                <td>
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>

                    {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts.destroy', $post], 'class' => 'form-inline', 'data-confirm' => __('forms.posts.delete')]) !!}
                        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'name' => 'submit', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
