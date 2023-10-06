<x-card :id="dom_id($comment)" class="mb-3">
  <div class="card-title d-flex justify-content-between">
    <h6>
        <a href="{{ route('users.show', $comment->author) }}">
          {{ $comment->author->name }}
        </a>
    </h6>

    @can('delete', $comment)
      <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="form-inline" data-turbo="true" data-turbo-confirm="@lang('forms.comments.delete')">
        @method('DELETE')
        @csrf

        <button type="submit" class="btn-close"></button>
      </form>
    @endcan
  </div>

  <p class="card-text">
    {{ $comment->content }}
  </p>

  <p class="card-text">
    <small class="text-muted">@humanize_date($comment->posted_at)</small>
  </p>
</x-card>
