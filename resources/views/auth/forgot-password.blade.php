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

        <form action="{{ route('password.email') }}" method="POST" role="form">
            @csrf

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
                    value="{{ old('email') }}"
                >

                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="@lang('auth.send_password_reset_link')">
            </div>
        </form>
    </div>
</div>
@endsection
