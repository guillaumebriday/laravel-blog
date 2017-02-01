{!! Form::model($post, ['route' => ['admin.posts.update', $post], 'method' =>'PUT' ]) !!}

    <div class="form-group col-md-12">
        {!! Form::label('title', __('posts.attributes.title')) !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('author_id', __('posts.attributes.author')) !!}
        {!! Form::select('author_id', $users, null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('posted_at', __('posts.attributes.posted_at')) !!}
        {!! Form::text('posted_at', $post->posted_at->format('d/m/Y H:i:s'), ['class' => 'form-control datepicker', 'required' => 'required']) !!}
    </div>

    <div class="form-group col-md-12">
        {!! Form::label('content', __('posts.attributes.content')) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    {!! Form::submit(__('forms.actions.update'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
