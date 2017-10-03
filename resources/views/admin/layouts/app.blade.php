<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body bg-light">
    <div id="app">
        @include('shared/navbar')

        <div class="container-fluid {{ Request::is('admin/dashboard') ? '' : 'bg-white' }}">
            <div class="row">
                @include('admin/shared/sidebar')

                <main class="col-lg-10 ml-md-auto">
                    @include('shared/alerts')

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/admin.js"></script>
</body>
</html>
