<div class="panel panel-default">
    <div class="panel-heading">{{ trans('comments.add_comment') }}</div>
    <div class="panel-body">
        {!! Form::open(['route' => 'comments.store', 'method' => 'post']) !!}
            {!! Form::hidden('post_id', $post->id) !!}
            <div class="form-group">
                {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => trans('comments.placeholder.content'), 'rows' => '4']) !!}
            </div>
            {!! Form::submit(trans('comments.comment'), ['class' => 'btn btn-primary pull-right']) !!}
        {!! Form::close() !!}
    </div>
</div>
