<!DOCTYPE html>
<html lang="en">
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

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="admin-body">
    @include('admin/shared/navbar')

    <div class="container">
        @include('shared/alerts')

        <div class="row">
            <div class="col-md-3">
                @include('admin/shared/sidebar')
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/admin.js"></script>
</body>
</html>
