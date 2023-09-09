<x-card>
  @if ($post->hasThumbnail())
    <x-slot:image>
      <a href="{{ route('posts.show', $post)}}">
        <img src="{{ $post->thumbnail->getUrl('thumb') }}" alt="{{ $post->thumbnail->name }}" class="card-img-top">
      </a>
    </x-slot>
  @endif

  <h4 v-pre class="card-title">
    <a href="{{ route('posts.show', $post) }}">
      {{ $post->title }}
    </a>
  </h4>

  <p class="card-text">
    <small v-pre class="text-muted">
      <a href="{{ route('users.show', $post->author) }}">
        {{ $post->author->fullname }}
      </a>
    </small>
  </p>

  <div class="card-text">
    <small class="text-muted">{{ humanize_date($post->posted_at) }}</small><br>
    <small class="text-muted">
      <x-icon name="comments" prefix="fa-regular" /> {{ $post->comments_count }}

      @include('likes/_likes')
    </small>
  </div>
</x-card>
