@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <h1>{!! __('comments.on_post', ['post' => link_to_route('posts.show', $comment->post->title, $comment->post)]) !!}</h1>
    </div>

    @include('admin/comments/_form')
@endsection
