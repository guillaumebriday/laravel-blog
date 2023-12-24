@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1>@lang('auth.login')</h1>

        <form action="{{ route('login') }}" method="POST" role="form">
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="form-label control-label">
                    @lang('validation.attributes.email')
                </label>

                <input
                    type="text"
                    id="email"
                    name="email"
                    @class(['form-control', 'is-invalid' => $errors->has('email')])
                    required
                    autofocus
                    value="{{ old('email') }}"
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
                    @class(['form-control', 'is-invalid' => $errors->has('password')])
                    required
                >

                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" @checked(old('remember'))>

                        @lang('auth.remember_me')
                    </label>
                </div>
            </div>

            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="@lang('auth.login')">

                <a href="{{ route('password.request') }}" class="btn btn-link">
                    @lang('auth.forgotten_password')
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
