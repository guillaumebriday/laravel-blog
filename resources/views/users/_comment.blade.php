<div class="card mb-2">
  <div class="card-body">
    <div class="card-title">
      @lang('comments.posted_on') <a v-pre href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
    </div>

    <p v-pre class="card-text">{{ $comment->content }}</p>
    <p class="card-text">
      <small class="text-muted">{{ humanize_date($comment->posted_at) }}</small>
    </p>
  </div>
</div>
