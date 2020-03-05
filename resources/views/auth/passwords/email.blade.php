@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center m-3">
    <div class="col-md-6">
        <h1>@lang('auth.reset_password')</h1>

        @if (session('status'))
            <x-alert type="success" :dismissible="true">
                {{ session('status') }}
            </x-alert>
        @endif

        {!! Form::open(['route' => 'password.email', 'role' => 'form', 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('email', __('validation.attributes.email'), ['class' => 'control-label']) !!}
                {!! Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required']) !!}

                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::submit(__('auth.send_password_reset_link'), ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection
