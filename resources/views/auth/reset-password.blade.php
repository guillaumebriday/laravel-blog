@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center m-3">
    <div class="col-md-6">
        <h1>@lang('auth.reset_password')</h1>

        <form action="{{ route('password.store') }}" method="POST" role="form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group mb-3">
                <label for="email" class="form-label control-label">
                    @lang('validation.attributes.email')
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    @class(['form-control', 'is-invalid' => $errors->has('email')])
                    required
                    value="{{ $email ?? old('email') }}"
                >

                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label control-label">
                    @lang('validation.attributes.password')
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    @class(['form-control', 'is-invalid' => $errors->has('password')])
                    required
                >

                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label control-label">
                    @lang('validation.attributes.password_confirmation')
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')])
                    required
                >

                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="@lang('auth.reset_password')">
            </div>
        </form>
    </div>
</div>
@endsection
