<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="api-token" content="{{ auth()->user()->api_token }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div id="app">
        @include('shared/navbar')

        <div class="container {{ (Request::is('/') || Request::is('posts/*') || Request::is('login') || Request::is('register')) ? '' : 'bg-white' }}">
            @include('shared/alerts')

            <div class="row">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('shared/footer')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('inline-scripts')
</body>
</html>
