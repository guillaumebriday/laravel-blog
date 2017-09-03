{!! Form::model($comment, ['route' => ['admin.comments.update', $comment], 'method' =>'PUT' ]) !!}

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('author_id', __('comments.attributes.author')) !!}
            {!! Form::select('author_id', $users, null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('posted_at', __('comments.attributes.posted_at')) !!}
            <input type="datetime-local" name="posted_at" class="form-control" required value="{{ old('posted_at') ?? $comment->posted_at->format('Y-m-d\TH:i') }}">
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('content', __('comments.attributes.content')) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary pull-left']) !!}

{!! Form::close() !!}

{!! Form::model($comment, ['method' => 'DELETE', 'route' => ['admin.comments.destroy', $comment], 'class' => 'form-inline pull-right', 'data-confirm' => __('forms.comments.delete')]) !!}
    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('comments.delete'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
{!! Form::close() !!}
