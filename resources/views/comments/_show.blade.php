<div class="card mt-2">
  <div class="card-body">
    <div class="card-title d-flex justify-content-between">
      <h6>{{ link_to_route('users.show', $comment->author->fullname, $comment->author) }}</h6>
      @include('comments/_delete')
    </div>

    <p class="card-text">{{ $comment->content }}</p>
    <p class="card-text"><small class="text-muted">{{ humanize_date($comment->posted_at) }}</small></p>
  </div>
</div>
