{!! Form::model($comment, ['route' => ['admin.comments.update', $comment], 'method' =>'PUT' ]) !!}

    <div class="form-group col-md-6">
        {!! Form::label('author_id', __('comments.attributes.author')) !!}
        {!! Form::select('author_id', $users, null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('posted_at', __('comments.attributes.posted_at')) !!}
        {!! Form::text('posted_at', humanize_date($comment->posted_at, 'd/m/Y H:i:s'), ['class' => 'form-control datepicker', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-12">
        {!! Form::label('content', __('comments.attributes.content')) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
