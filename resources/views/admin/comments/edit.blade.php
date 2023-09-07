@extends('admin.layouts.app')

@section('content')
    <p>
        @lang('posts.show') :
        <a href="{{ route('posts.show', $comment->post) }}">
            {{ route('posts.show', $comment->post) }}
        </a>
    </p>

    @include('admin/comments/_form')
@endsection
