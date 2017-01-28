@extends('layouts.app')

@section('content')
    @component('components.panels.default')
        @slot('title')
            {{ trans('posts.last_posts') }}
            <a href="{{ route('posts.feed') }}" class="pull-right" data-turbolinks="false">
                <i class="fa fa-rss" aria-hidden="true"></i>
            </a>
        @endslot

        @include ('posts/_list')
    @endcomponent
@endsection
