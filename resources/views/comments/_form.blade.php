@component('components.panels.default')
    @slot('title')
        {{ __('comments.add_comment') }}
    @endslot

    @if (Auth::check())
        {!! Form::open(['route' => 'comments.store', 'method' => 'post']) !!}
            {!! Form::hidden('post_id', $post->id) !!}
            <div class="form-group">
                {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => __('comments.placeholder.content'), 'rows' => '4']) !!}
            </div>
            {!! Form::submit(__('comments.comment'), ['class' => 'btn btn-primary pull-right']) !!}
        {!! Form::close() !!}
    @else
        {{ __('comments.sign_in_to_comment') }}
    @endif
@endcomponent
