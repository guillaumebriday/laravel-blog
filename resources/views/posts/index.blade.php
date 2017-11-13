@extends('layouts.app')

@section('content')

  @include ('posts/_search_form')

  <div class="d-flex justify-content-between">
    <div class="p-2">
      @if (request()->has('q'))
        <h2>{{ trans_choice('posts.search_results', $posts->count(), ['query' => request()->input('q')]) }}</h2>
      @else
        <h2>@lang('posts.last_posts')</h2>
      @endif
    </div>

    <div class="p-2">
      <a href="{{ route('posts.feed') }}" class="pull-right" data-turbolinks="false">
          <i class="fa fa-rss" aria-hidden="true"></i>
      </a>
    </div>
  </div>

  @include ('posts/_list')
@endsection
