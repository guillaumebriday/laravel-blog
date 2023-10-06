<x-card>
  <h5 class="card-title">
    @lang('comments.posted_on') <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
  </h5>

  <p class="card-text">{{ $comment->content }}</p>

  <p class="card-text">
    <small class="text-body-secondary">@humanize_date($comment->posted_at)</small>
  </p>
</x-card>
