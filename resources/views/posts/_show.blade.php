<div class="card">
  @if ($post->hasThumbnail())
      {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'card-img-top']) }}
  @endif

  <div class="card-body">
    <h4 class="card-title">{{ link_to_route('posts.show', $post->title, $post) }}</h4>

    <p class="card-text"><small class="text-muted">{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</small></p>
    <div class="card-text post-content">{!! $post->content !!}</div>
    <p class="card-text"><small class="text-muted">{{ humanize_date($post->posted_at) }}</small></p>
  </div>
</div>
