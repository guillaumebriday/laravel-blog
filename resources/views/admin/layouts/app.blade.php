<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite([
        'resources/sass/app.scss',
        'resources/sass/admin.scss',
        'resources/js/app.js',
        'resources/js/admin.js'
    ])
</head>
<body class="admin-body bg-dark">
    @include('admin/shared/navbar')

    <div class="content-wrapper bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    @include('shared/alerts')

                    <x-card>
                        @yield('content')
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
