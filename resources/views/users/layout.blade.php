@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-3 mb-3">
    <div class="card">
      <div class="card-header">@lang('users.profile')</div>
      <div class="list-group list-group-flush">
        <a href="{{ route('users.edit') }}" @class(['list-group-item', 'active' => $tab == 'profile'])>
          <x-icon name="user" prefix="fa-regular" />

          @lang('users.profile')
        </a>

        <a href="{{ route('users.password') }}" @class(['list-group-item', 'active' => $tab == 'security'])>
          <x-icon name="lock" />

          @lang('users.security')
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-9">
      @yield('main_content')
  </div>
</div>
@endsection
