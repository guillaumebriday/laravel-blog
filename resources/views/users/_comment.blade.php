<div class="card mb-2">
  <div class="card-body">
    <div class="card-title">
      @lang('comments.posted_on') <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
    </div>

    <p class="card-text">{{ $comment->content }}</p>
    <p class="card-text">
      <small class="text-muted">{{ humanize_date($comment->posted_at) }}</small>
    </p>
  </div>
</div>
