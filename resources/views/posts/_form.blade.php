@component('components.panels.default')
    @slot('title')
        {{ __('posts.add_article') }}
    @endslot

    {!! Form::open(['route' => 'posts.store', 'method' => 'post', 'files' => true]) !!}
        <div class="form-group">
          {!! Form::label('title', __('posts.attributes.title')) !!}
          {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('posts.placeholder.title')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('thumbnail', __('posts.attributes.thumbnail')) !!}
            {!! Form::file('thumbnail', ['accept' => 'image/*']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('content', __('posts.attributes.content')) !!}
            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => __('posts.placeholder.content')]) !!}
        </div>
        {!! Form::submit(__('posts.publish'), ['class' => 'btn btn-primary pull-right']) !!}
    {!! Form::close() !!}
@endcomponent
