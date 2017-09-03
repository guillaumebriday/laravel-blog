{!! Form::model($post, ['route' => ['admin.posts.update', $post], 'method' =>'PUT' ]) !!}

    <div class="form-group">
        {!! Form::label('title', __('posts.attributes.title')) !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('author_id', __('posts.attributes.author')) !!}
            {!! Form::select('author_id', $users, null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('posted_at', __('posts.attributes.posted_at')) !!}
            <input type="datetime-local" name="posted_at" class="form-control" required value="{{ old('posted_at') ?? $post->posted_at->format('Y-m-d\TH:i') }}">
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('content', __('posts.attributes.content')) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary pull-left']) !!}

{!! Form::close() !!}

{!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts.destroy', $post], 'class' => 'form-inline pull-right', 'data-confirm' => __('forms.posts.delete')]) !!}
    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i> ' . __('posts.delete'), ['class' => 'btn btn-link text-danger', 'name' => 'submit', 'type' => 'submit']) !!}
{!! Form::close() !!}
