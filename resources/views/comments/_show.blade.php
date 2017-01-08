<div class="panel panel-default">
    <div class="panel-heading">
        <span>{{ link_to_route('users.show', user_name($comment->author), $comment->author) }}</span>
        <span class="pull-right">
          <time>{{ humanize_date($comment->posted_at) }}</time>

          @can('delete', $comment)
            {!! Form::model($comment, ['method' => 'DELETE', 'route' => ['comments.destroy', $comment->id], 'class' => 'form-inline delete-confirmation']) !!}
              <button type="submit" name="submit" class="btn btn-link">
                <span class="text-danger glyphicon glyphicon-remove" aria-hidden="true"></span>
              </button>
            {!! Form::close() !!}
          @endcan
        </span>
    </div>
    <div class="panel-body">
        {{ $comment->content }}
    </div>
</div>
