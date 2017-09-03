<h5>{{ __('comments.add_comment') }}</h5>

@if (Auth::check())
    {!! Form::open(['route' => 'comments.store', 'method' => 'post']) !!}
        {!! Form::hidden('post_id', $post->id) !!}

        <div class="form-group">
            {!! Form::textarea('content', old('content'), ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : ''), 'placeholder' => __('comments.placeholder.content'), 'rows' => '4', 'required']) !!}

            @if ($errors->has('content'))
                <span class="invalid-feedback">{{ $errors->first('content') }}</span>
            @endif
        </div>

        <div class="form-group text-right">
            {!! Form::submit(__('comments.comment'), ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@else
    @component('components.alerts.default', ['type' => 'warning'])
      {{ __('comments.sign_in_to_comment') }}
    @endcomponent
@endif
