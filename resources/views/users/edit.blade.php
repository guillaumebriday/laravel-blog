@extends('layouts.app')

@section('content')
    @component('components.panels.default')
        @slot('title')
            <strong>{{ user_name($user) }}</strong>
        @endslot

        @include ('users/_form')
    @endcomponent
@endsection
