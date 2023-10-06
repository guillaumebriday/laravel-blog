<div class="col">
  <x-card>
    @if ($post->hasThumbnail())
      <x-slot:image>
        <a href="{{ route('posts.show', $post)}}" data-turbo-frame="_top">
          <img src="{{ $post->thumbnail->getUrl('thumb') }}" alt="{{ $post->thumbnail->name }}" class="card-img-top">
        </a>
      </x-slot>
    @endif

    <h4 class="card-title">
      <a href="{{ route('posts.show', $post) }}" data-turbo-frame="_top">
        {{ $post->title }}
      </a>
    </h4>

    <p class="card-text">
      <small class="text-body-secondary">
        <a href="{{ route('users.show', $post->author) }}" data-turbo-frame="_top">
          {{ $post->author->fullname }}
        </a>
      </small>
    </p>

    <div class="card-text">
      <small class="text-body-secondary">@humanize_date($post->posted_at)</small><br>
      <small class="text-body-secondary">
        <x-icon name="comments" prefix="fa-regular" /> {{ $post->comments_count }}

        @include('likes/_likes')
      </small>
    </div>
  </x-card>
</div>
