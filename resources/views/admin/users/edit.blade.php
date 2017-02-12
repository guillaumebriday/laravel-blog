@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>{{ user_name($user) }} <small>{{ link_to_route('users.show', __('users.show'), $user) }}</small></h1>
    </div>

    @include('admin/users/_form')
@endsection
