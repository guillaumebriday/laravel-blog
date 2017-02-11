@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
      <h1>{{ $post->title }} <small>{{ link_to_route('posts.show', __('posts.show'), $post) }}</small></h1>
    </div>

    @include('admin/posts/_form')
@endsection
