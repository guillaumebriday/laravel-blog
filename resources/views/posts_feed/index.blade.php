@extends('layouts.rss')

@section('content')
    @each('posts_feed/_show', $posts, 'post')
@endsection
