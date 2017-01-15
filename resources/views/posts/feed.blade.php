@extends('layouts.rss')

@section('content')
    @each('posts/feed/_show', $posts, 'post')
@endsection
