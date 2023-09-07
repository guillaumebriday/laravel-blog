@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1>@lang('auth.register')</h1>

        {!! Form::open(['route' => 'register', 'role' => 'form', 'method' => 'POST']) !!}
            <div class="form-group">
                <label for="name" class="control-label">
                    @lang('validation.attributes.name')
                </label>
                {!! Form::text('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required', 'autofocus']) !!}

                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="control-label">
                    @lang('validation.attributes.email')
                </label>
                {!! Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required']) !!}

                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="control-label">
                    @lang('validation.attributes.password')
                </label>
                {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required']) !!}

                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="control-label">
                    @lang('validation.attributes.password_confirmation')
                </label>
                {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'required']) !!}

                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::submit(__('auth.register'), ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection
