@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>{{ user_name($user) }}</strong>
        </div>
        <div class="panel-body">
            @include ('users/_profil')
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="pill" href="#posts">{{ trans('posts.last_posts')}}</a></li>
        <li><a data-toggle="pill" href="#comments">{{ trans('comments.last_comments')}}</a></li>
    </ul>

    <div class="tab-content">
        <div id="posts" class="tab-pane active">
            @each('posts/user/_show', $posts, 'post')
        </div>
        <div id="comments" class="tab-pane">
            @each('comments/user/_show', $comments, 'comment')
        </div>
    </div>
@endsection
