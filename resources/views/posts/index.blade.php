@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('posts.last_posts') }}</div>

        <div class="panel-body">
            @include ('posts/_list')
        </div>
    </div>
@endsection
