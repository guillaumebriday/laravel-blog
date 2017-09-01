@can('delete', $comment)
  {!! Form::model($comment, ['method' => 'DELETE', 'route' => ['comments.destroy', $comment], 'data-confirm' => __('forms.comments.delete')]) !!}
    {{ Form::button('<span aria-hidden="true">&times;</span>', ['class' => 'close text-danger', 'aria-label' => 'Close', 'type' => 'submit']) }}
  {!! Form::close() !!}
@endcan
