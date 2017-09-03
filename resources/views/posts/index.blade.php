@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between">
    <div class="p-2">
      <h2>{{ __('posts.last_posts') }}</h2>
    </div>

    <div class="p-2">
      <a href="{{ route('posts.feed') }}" class="pull-right" data-turbolinks="false">
          <i class="fa fa-rss" aria-hidden="true"></i>
      </a>
    </div>
  </div>

  @include ('posts/_list')
@endsection
