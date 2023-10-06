@if ($post->hasThumbnail())
    <img src="{{ $post->thumbnail->getUrl('thumb') }}" alt="{{ $post->thumbnail->name }}" class="img-thumbnail" width="350">

    <form action="{{ route('admin.posts_thumbnail.destroy', $post) }}" method="POST" data-confirm="@lang('forms.posts.delete_thumbnail')">
        @method('DELETE')
        @csrf

        <button type="submit" name="submit" class="btn btn-link">
            <x-icon name="trash" />

            @lang('posts.delete_thumbnail')
        </button>
    </form>
@endif
