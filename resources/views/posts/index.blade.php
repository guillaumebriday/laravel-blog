@extends('layouts.app')

@section('content')

  @include ('posts/_search_form')

  <x-turbo-frame id="posts">
    <div class="d-flex justify-content-between gap-2">
      <div class="p-2">
        @if (request()->has('q'))
          <h2>{{ trans_choice('posts.search_results', $posts->count(), ['query' => request()->input('q')]) }}</h2>
        @else
          <h2>@lang('posts.last_posts')</h2>
        @endif
      </div>

      <div class="p-2">
        <a href="{{ route('posts.feed') }}" data-turbo="false">
          <x-icon name="rss" />
        </a>
      </div>
    </div>

    @include ('posts/_list')
  </x-turbo-frame>
@endsection
