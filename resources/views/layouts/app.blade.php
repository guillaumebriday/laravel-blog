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

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    @include('shared/navbar')

    <div class="container">
        @include('shared/alerts')

        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>

    <nav class="navbar navbar-dark bg-dark fixed-bottom footer">
        <div class="container">
            @yield('footer')
            @include('shared/newsletter-form')
        </div>
    </nav>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('inline-scripts')
</body>
</html>
