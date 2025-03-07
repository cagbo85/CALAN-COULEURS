<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    @viteReactRefresh
    @vite('resources/js/app.jsx', 'resources/css/app.css')
</head>

<body>
    <h1 class="text-3xl text-red-500 font-bold underline">
        Hello world
    </h1>
    <body>
        <div id="app" data-component="buttonPrimary"></div>
    </body>
</body>

</html>
