<div class="card mb-2">
  @if ($post->hasThumbnail())
    <a href="{{ route('posts.show', $post)}}">
      {{ Html::image($post->thumbnail->getUrl('thumb'), $post->thumbnail->name, ['class' => 'card-img-top']) }}
    </a>
  @endif

  <div class="card-body">
    <h4 v-pre class="card-title">
      {{ link_to_route('posts.show', $post->title, $post) }}
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
