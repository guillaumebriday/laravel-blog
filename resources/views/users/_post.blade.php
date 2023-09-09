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
        <i class="fa-regular fa-comments" aria-hidden="true"></i> {{ $post->comments_count }}
        <i class="fa-regular fa-heart ml-2" aria-hidden="true"></i> {{ $post->likes_count }}
      </small>
    </p>
  </div>
</div>
