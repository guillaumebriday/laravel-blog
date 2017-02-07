<h1>{{ __('newsletter.email.welcome') }}</h1>

<p>
    {{ __('newsletter.email.description', ['count' => $posts->count()]) }} :
</p>

<ul>
    @foreach($posts as $post)
        <li>{{ link_to_route('posts.show', $post->title, $post) }}</li>
    @endforeach
</ul>

<p>
    {{ __('newsletter.email.thanks') }}
</p>

<p>
    {{ link_to_route('newsletter-subscriptions.unsubscribe', __('newsletter.email.unsubscribe'), ['email' => $email]) }}
</p>
