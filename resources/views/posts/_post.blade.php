<div class="col">
  <x-card class="border-0">
    @if ($post->hasThumbnail())
      <x-slot:image>
        <a href="{{ route('posts.show', $post)}}" data-turbo-frame="_top">
          <img src="{{ $post->thumbnail->getUrl('thumb') }}" alt="{{ $post->thumbnail->name }}" class="card-img-top rounded-4">
        </a>
      </x-slot>
    @endif

    <small class="text-body-secondary">
      @humanize_date($post->posted_at)
    </small>

    <h4 class="card-title mt-1 mb-3">
      <a href="{{ route('posts.show', $post) }}" class="link-dark" data-turbo-frame="_top">
        {{ $post->title }}
      </a>
    </h4>

    <p class="card-text text-body-secondary">
      {{ Str::words(strip_tags($post->content), 10) }}
    </p>

    <p class="card-text">
      <small>
        <a href="{{ route('users.show', $post->author) }}" class="link-secondary" data-turbo-frame="_top">
          {{ $post->author->fullname }}
        </a>
      </small>
    </p>

    <div class="card-text">
      <small class="text-body-secondary">
        <x-icon name="comments" prefix="fa-regular" /> {{ $post->comments_count }}

        @include('likes/_likes')
      </small>
    </div>
  </x-card>
</div>
