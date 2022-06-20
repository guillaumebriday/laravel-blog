@auth
  {!! Form::open(['id' => 'comments_form', 'route' => ['comments.store'], 'method' => 'POST', 'data-turbo' => 'true']) !!}
    {!! Form::hidden('post_id', $post->id) !!}

    <div class="form-group">
      {!! Form::textarea('content', null, ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : ''), 'placeholder' => __('comments.placeholder.content'), 'required']) !!}

      @error('content')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group text-right">
      {!! Form::submit(__('comments.comment'), ['class' => 'btn btn-primary']) !!}
    </div>
  {!! Form::close() !!}
@else
  <x-alert type="warning">
    @lang('comments.sign_in_to_comment')
  </x-alert>
@endauth
