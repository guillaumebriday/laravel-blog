<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link>{{ url()->current() }}</link>
        @yield('content')
    </channel>
</rss>

