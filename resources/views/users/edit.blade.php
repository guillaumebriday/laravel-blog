@extends('users.layout', ['tab' => 'profile'])

@section('main_content')
  <div class="card">
    <div class="card-body">
      <h1>@lang('users.profile')</h1>
      <hr class="my-4">

      {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update']]) !!}

        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">
            @lang('users.attributes.name')
          </label>

          <div class="col-sm-5">
            {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.name'), 'required']) !!}

            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">
            @lang('users.attributes.email')
          </label>

          <div class="col-sm-5">
            {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('users.placeholder.email'), 'required']) !!}

            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group offset-sm-2">
          {!! Form::submit(__('forms.actions.save'), ['class' => 'btn btn-primary']) !!}
        </div>

      {!! Form::close() !!}
    </div>
  </div>
@endsection
