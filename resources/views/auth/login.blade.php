@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ __('auth.login') }}</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">{{ __('validation.attributes.email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">{{ __('validation.attributes.password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> {{ __('auth.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.login') }}
                        </button>

                        {{ link_to('/password/reset', __('auth.forgotten_password'), ['class' => 'btn btn-link'])}}
                    </div>
                </div>
            </form>

            <hr>

            <div class="text-center">
                <a href="{{ route('auth.provider', ['provider' => 'github']) }}" class="btn btn-default">
                    {{ __('auth.services.github') }}
                    <i class="fa fa-github" aria-hidden="true"></i>
                </a>

                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-default">
                    {{ __('auth.services.twitter') }}
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
