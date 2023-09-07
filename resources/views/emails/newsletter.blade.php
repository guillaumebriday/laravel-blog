<h1>@lang('newsletter.email.welcome')</h1>

<p>
    @lang('newsletter.email.description', ['count' => $posts->count()]) :
</p>

<ul>
    @foreach($posts as $post)
        <li>
            <a href="{{ route('posts.show', $post) }}">
                {{ $post->title }}
            </a>
        </li>
    @endforeach
</ul>

<p>
    @lang('newsletter.email.thanks')
</p>

<p>
    <a href="{{ route('newsletter-subscriptions.unsubscribe', ['email' => $email]) }}">
        @lang('newsletter.email.unsubscribe')
    </a>
</p>
