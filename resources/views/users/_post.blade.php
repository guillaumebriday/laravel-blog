<div class="card mb-2">
  <div class="card-body">
    <h4 class="card-title">
      {{ link_to_route('posts.show', $post->title, $post) }}
    </h4>

    <div class="card-text post-content">{!! $post->content !!}</div>
    <p class="card-text">
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small><br>
      <small class="text-muted">
        <i class="fa fa-comments-o" aria-hidden="true"></i> {{ $post->comments_count }}
        <i class="fa fa-heart-o ml-2" aria-hidden="true"></i> {{ $post->likes_count }}
      </small>
    </p>
  </div>
</div>
