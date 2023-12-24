@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card>
                <x-slot:title>
                    @lang('Verify Your Email Address')
                </x-slot>

                @if (session('status') == 'verification-link-sent')
                    <x-alert type="success">
                        @lang('A fresh verification link has been sent to your email address.')
                    </x-alert>
                @endif

                @lang('Before proceeding, please check your email for a verification link.')
                @lang('If you did not receive the email'),

                <form action="{{ route('verification.send') }}" method="POST" class="d-inline" role="form">
                    @csrf

                    <input type="submit" class="btn btn-link p-0 m-0 align-baseline" value="@lang('click here to request another')">
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection
