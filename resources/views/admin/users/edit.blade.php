@extends('admin.layouts.app')

@section('content')
    <p>@lang('users.show') : {{ link_to_route('users.show', route('users.show', $user), $user) }}</p>

    @include('admin/users/_form')
@endsection
