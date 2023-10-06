@auth
    <x-turbo-frame :id="[$post, 'like']">
        @if ($post->isLiked())
            <form action="{{ route('posts.likes.destroy', $post) }}" method="POST" class="form-inline" data-turbo="true">
                @method('DELETE')
                @csrf

                <button type="submit" name="submit" class="btn btn-link p-0">
                    <x-icon name="heart" prefix="fa-regular" class="ms-2 text-danger" />
                </button>
            </form>
        @else
            <form action="{{ route('posts.likes.store', $post) }}" method="POST" class="form-inline" data-turbo="true">
                @csrf

                <button type="submit" name="submit" class="btn btn-link p-0">
                    <x-icon name="heart" prefix="fa-regular" class="ms-2" />
                </button>
            </form>
        @endif
    </x-turbo-frame>
@else
    <i
        class="fa-regular ms-2 fa-heart"
        aria-hidden="true"
    ></i>
@endauth
