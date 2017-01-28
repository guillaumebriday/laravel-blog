@component('components.panels.default')
    @slot('title')
        {{ trans('comments.add_comment') }}
    @endslot

    {!! Form::open(['route' => 'comments.store', 'method' => 'post']) !!}
        {!! Form::hidden('post_id', $post->id) !!}
        <div class="form-group">
            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => trans('comments.placeholder.content'), 'rows' => '4']) !!}
        </div>
        {!! Form::submit(trans('comments.comment'), ['class' => 'btn btn-primary pull-right']) !!}
    {!! Form::close() !!}
@endcomponent
