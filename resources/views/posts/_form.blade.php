<div class="panel panel-default">
    <div class="panel-heading">{{ trans('posts.add_article') }}</div>
    <div class="panel-body">
        {!! Form::open(['route' => 'posts.store', 'method' => 'post']) !!}
            <div class="form-group">
              {!! Form::label('title', trans('posts.attributes.title')) !!}
              {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('posts.placeholder.title')]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('content', trans('posts.attributes.content')) !!}
                {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => trans('posts.placeholder.content')]) !!}
            </div>
            {!! Form::submit(trans('posts.publish'), ['class' => 'btn btn-primary pull-right']) !!}
        {!! Form::close() !!}
    </div>
</div>
