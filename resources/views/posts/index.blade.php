@extends('layouts.app')

@section('content')
  @include ('posts/_search_form')

  <x-turbo-frame id="posts">
    <div class="d-flex justify-content-between gap-3 mt-3">
      <div class="p-2">
        <h2>
          @if (filled(request('q')))
            {{ trans_choice('posts.search_results', $posts->count()) }}
          @else
            @lang('posts.last_posts')
          @endif
        </h2>
      </div>

      <div class="p-2">
        <a href="{{ route('posts.feed') }}" data-turbo="false">
          <x-icon name="rss" />
        </a>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      @each('posts/_post', $posts, 'post', 'posts/_empty')
    </div>

    <div class="d-flex justify-content-center">
      {{ $posts->links() }}
    </div>
  </x-turbo-frame>
@endsection
