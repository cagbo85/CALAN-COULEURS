<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    @viteReactRefresh
    @vite('resources/js/app.jsx', 'resources/css/app.css')

    <title>CALAN-COULEURS</title>

</head>

<body class="bg-white flex flex-col h-screen">
    @include('partials.navbar')
    <div class="flex-grow">
        @yield('content')
    </div>
    @include('partials.footer')
</body>

</html>
