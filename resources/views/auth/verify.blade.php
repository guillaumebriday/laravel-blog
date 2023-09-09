@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},

                    <form action="{{ route('verification.resend') }}" method="POST" class="d-inline" role="form">
                        @csrf

                        <input type="submit" class="btn btn-link p-0 m-0 align-baseline" value="@lang('click here to request another')">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
