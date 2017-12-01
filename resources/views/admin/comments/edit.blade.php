@extends('admin.layouts.app')

@section('content')
    <p>@lang('posts.show') : {{ link_to_route('posts.show', route('posts.show', $comment->post), $comment->post) }}</p>
    @include('admin/comments/_form')
@endsection
