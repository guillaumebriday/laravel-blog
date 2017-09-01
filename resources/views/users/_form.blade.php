{!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user]]) !!}

  <div class="form-group row">
    {!! Form::label('name', __('users.attributes.name'), ['class' => 'col-sm-2 col-form-label']) !!}

    <div class="col-sm-5">
      {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required']) !!}

      @if ($errors->has('name'))
          <span class="invalid-feedback">{{ $errors->first('name') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('email', __('users.attributes.email'), ['class' => 'col-sm-2 col-form-label']) !!}

    <div class="col-sm-5">
      {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), 'required']) !!}

      @if ($errors->has('email'))
          <span class="invalid-feedback">{{ $errors->first('email') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('password', __('users.attributes.password'), ['class' => 'col-sm-2 col-form-label']) !!}

    <div class="col-sm-5">
      {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password')]) !!}

      @if ($errors->has('password'))
          <span class="invalid-feedback">{{ $errors->first('password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group row">
    {!! Form::label('password_confirmation', __('users.attributes.password_confirmation'), ['class' => 'col-sm-2 col-form-label']) !!}

    <div class="col-sm-5">
      {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation')]) !!}

      @if ($errors->has('password_confirmation'))
          <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group">
    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">{{ __('forms.actions.back') }}</a>
    {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-success']) !!}
  </div>

{!! Form::close() !!}
