<h1>{{ trans('newsletter.email.welcome') }}</h1>

<p>
  {{ trans('newsletter.email.description', ['count' => $posts->count()]) }} :
</p>

<ul>
  @foreach($posts as $post)
    <li>{{ link_to_route('posts.show', $post->title, $post) }}</li>
  @endforeach
</ul>

<p>
  {{ trans('newsletter.email.thanks') }}
</p>
