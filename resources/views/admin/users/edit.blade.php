@extends('admin.layouts.app')

@section('content')
    <p>
        @lang('users.show') :

        <a href="{{ route('users.show', $user) }}">
            {{ route('users.show', $user) }}
        </a>
    </p>

    @include('admin/users/_form')
@endsection
