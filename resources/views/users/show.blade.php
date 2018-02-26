@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-2">
        <div class="card-body text-center">
          <h2 v-pre class="card-title mb-0">{{ $user->name }}</h2>
          <small class="card-subtitle mb-2 text-muted">{{ $user->email }}</small>

          <div class="card-text row mt-3">
            <div class="col-md-4">
              <span class="text-muted d-block">@lang('comments.comments')</span>
              {{ $comments_count }}
            </div>

            <div class="col-md-4">
              <span class="text-muted d-block">@lang('posts.posts')</span>
              {{ $posts_count }}
            </div>

            <div class="col-md-4">
              <span class="text-muted d-block">@lang('likes.likes')</span>
              {{ $likes_count }}
            </div>
          </div>

          @profile($user)
            {{ link_to_route('users.edit', __('users.edit'), [], ['class' => 'btn btn-primary btn-sm float-right']) }}
          @endprofile
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <h2>@lang('comments.last_comments')</h2>
      @each('users/_comment', $comments, 'comment')
    </div>

    <div class="col-md-6">
      <h2>@lang('posts.last_posts')</h2>
      @each('users/_post', $posts, 'post')
    </div>
  </div>
@endsection
