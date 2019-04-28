@extends('users.layout', ['tab' => 'security'])

@section('main_content')
  <div class="card">
    <div class="card-body">
      <h1>@lang('users.security')</h1>
      <hr class="my-4">

      {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.password.update', $user]]) !!}

        <div class="form-group row">
          {!! Form::label('current_password', __('users.attributes.current_password'), ['class' => 'col-sm-4 col-form-label']) !!}

          <div class="col-sm-8">
            {!! Form::password('current_password', ['class' => 'form-control' . ($errors->has('current_password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.current_password'), 'required']) !!}

            @error('current_password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          {!! Form::label('password', __('users.attributes.password'), ['class' => 'col-sm-4 col-form-label']) !!}

          <div class="col-sm-8">
            {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password'), 'required']) !!}

            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          {!! Form::label('password_confirmation', __('users.attributes.password_confirmation'), ['class' => 'col-sm-4 col-form-label']) !!}

          <div class="col-sm-8">
            {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.password_confirmation'), 'required']) !!}

            @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group offset-sm-4">
          {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-success']) !!}
        </div>

      {!! Form::close() !!}
    </div>
  </div>
@endsection
