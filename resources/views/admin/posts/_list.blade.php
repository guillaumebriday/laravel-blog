<table class="table table-striped table-sm table-responsive-md">
    <caption>{{ trans_choice('posts.count', $posts->total()) }}</caption>
    <thead>
        <tr>
            <th>@lang('posts.attributes.title')</th>
            <th>@lang('posts.attributes.author')</th>
            <th>@lang('posts.attributes.posted_at')</th>
            <th><x-icon name="comments" prefix="fa-regular" /></th>
            <th><x-icon name="heart" prefix="fa-regular" /></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <td>
                    <a href="{{ route('admin.posts.edit', $post) }}">
                        {{ $post->title }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $post->author) }}">
                        {{ $post->author->fullname }}
                    </a>
                </td>
                <td>@humanize_date($post->posted_at, 'd/m/Y H:i:s')</td>
                <td><span class="badge rounded-pill bg-secondary">{{ $post->comments_count }}</span></td>
                <td><span class="badge rounded-pill bg-secondary">{{ $post->likes_count }}</span></td>
                <td>
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                        <x-icon name="edit" />
                    </a>

                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="form-inline" data-confirm="@lang('forms.posts.delete')">
                        @method('DELETE')
                        @csrf

                        <button type="submit" name="submit" class="btn btn-outline-danger btn-sm">
                            <x-icon name="trash" />
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
