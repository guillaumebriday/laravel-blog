@extends('layouts.app')

@section('content')
  <div class="blog-post">
    @if ($post->hasThumbnail())
      {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-fluid rounded']) }}
    @endif

    <h1>{{ $post->title }}</h1>

    <div class="blog-post-meta">
      <small class="text-muted">{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</small>,
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small>
    </div>

    {{ $post->content }}
  </div>

  <hr>

  @include ('comments/_list')
@endsection
