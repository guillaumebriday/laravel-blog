@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12 mb-3">
    <a href="{{ route('users.show', $user) }}">
      <x-icon name="long-arrow-left" />

      @lang('users.public_profile')
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-header">@lang('users.profile')</div>
      <div class="list-group list-group-flush">
        <a href="{{ route('users.edit') }}" class="list-group-item {{ ($tab == 'profile') ? 'active' : '' }}">
          <x-icon name="user" prefix="fa-regular" />

          @lang('users.profile')
        </a>

        <a href="{{ route('users.password') }}" class="list-group-item {{ ($tab == 'security') ? 'active' : '' }}">
          <x-icon name="lock" />

          @lang('users.security')
        </a>

        <a href="{{ route('users.token') }}" class="list-group-item {{ ($tab == 'api_token') ? 'active' : '' }}">
          <x-icon name="key" />

          @lang('users.api_token')
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-9">
      @yield('main_content')
  </div>
</div>
@endsection
