<div id="@domid($comment)" class="card mb-2">
    <div class="card-body">
      <div class="card-title d-flex justify-content-between">
        <h6>
            {{ link_to_route('users.show', $comment->author->name, $comment->author) }}
        </h6>

        @can('delete', $comment)
          {!! Form::model($comment, ['method' => 'DELETE', 'route' => ['comments.destroy', $comment], 'class' => 'form-inline pull-right', 'data-turbo' => 'true', 'data-turbo-confirm' => __('forms.comments.delete')]) !!}
            {!! Form::button('<span aria-hidden="true">&times;</span>', ['class' => 'close text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
          {!! Form::close() !!}
        @endcan
      </div>

      <p class="card-text">
        {{ $comment->content }}
      </p>

      <p class="card-text">
        <small class="text-muted">{{ humanize_date($comment->posted_at) }}</small>
      </p>
    </div>
  </div>
</div>
