@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1>@lang('auth.login')</h1>

        <form action="{{ route('login') }}" method="POST" role="form">
            @csrf

            <div class="form-group">
                <label for="email" class="control-label">
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

            <div class="form-group">
                <label for="password" class="control-label">
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

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" @checked(old('remember'))>

                        @lang('auth.remember_me')
                    </label>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="@lang('auth.login')">

                <a href="/password/reset" class="btn btn-link">
                    @lang('auth.forgotten_password')
                </a>
            </div>
        </form>

        <hr>

        <div class="d-flex justify-content-between flex-wrap">
            @if (env('GITHUB_ID'))
                <a href="{{ route('auth.provider', ['provider' => 'github']) }}" class="btn btn-secondary mb-2">
                    @lang('auth.services.github')

                    <x-icon name="github" prefix="fa-brands" />
                </a>
            @endif

            @if (env('TWITTER_ID'))
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-secondary mb-2">
                    @lang('auth.services.twitter')

                    <x-icon name="twitter" prefix="fa-brands" />
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
