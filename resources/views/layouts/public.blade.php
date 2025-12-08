<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ config('app.name', 'Fashion Store') }}</title>

    {{-- FONT ROBOTO --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- TAILWIND --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Roboto', sans-serif !important;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    {{-- NAVBAR --}}
    @include('components.navbar')

    {{-- PAGE CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

</body>
</html>
