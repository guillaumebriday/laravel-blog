<div class="card mb-2">
  @if ($post->hasThumbnail())
    <a href="{{ route('posts.show', $post)}}">
      <img src="{{ $post->thumbnail->getUrl('thumb') }}" alt="{{ $post->thumbnail->name }}" class="card-img-top">
    </a>
  @endif

  <div class="card-body">
    <h4 v-pre class="card-title">
      <a href="{{ route('posts.show', $post) }}">
        {{ $post->title }}
      </a>
    </h4>

    <p class="card-text">
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small><br>
      <small class="text-muted">
        <x-icon name="comments" prefix="fa-regular" /> {{ $post->comments_count }}
        <x-icon name="heart" prefix="fa-regular" /> {{ $post->likes_count }}
      </small>
    </p>
  </div>
</div>
