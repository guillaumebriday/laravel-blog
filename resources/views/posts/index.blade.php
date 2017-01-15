@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('posts.last_posts') }}
            <a href="{{ route('posts.feed') }}" class="pull-right" data-turbolinks="false">
                <i class="fa fa-rss" aria-hidden="true"></i>
            </a>
        </div>

        <div class="panel-body">
            @include ('posts/_list')
        </div>
    </div>
@endsection
