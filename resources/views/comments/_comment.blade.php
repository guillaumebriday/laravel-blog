<x-card :id="dom_id($comment)" class="mb-3">
  <div class="card-title d-flex justify-content-between">
    <p class="card-text mb-0">
      <small class="text-muted">@humanize_date($comment->posted_at)</small>
    </p>

    @can('delete', $comment)
      <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="form-inline" data-turbo="true" data-turbo-confirm="@lang('forms.comments.delete')">
        @method('DELETE')
        @csrf

        <button type="submit" class="btn-close"></button>
      </form>
    @endcan
  </div>

  <h6>
    <a href="{{ route('users.show', $comment->author) }}">
      {{ $comment->author->name }}
    </a>
  </h6>

  <p class="card-text">
    {{ $comment->content }}
  </p>
</x-card>
