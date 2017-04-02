@extends('layouts.app')

@section('content')
    @component('components.panels.default')
        @slot('title')
            {{ __('posts.add_article') }}
        @endslot

        {!! Form::open(['route' => 'posts.store', 'method' => 'post', 'files' => true]) !!}
            @include ('posts/_form')
        {!! Form::close() !!}
    @endcomponent
@endsection
