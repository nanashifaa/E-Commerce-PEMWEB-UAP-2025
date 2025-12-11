<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ config('app.name', 'CheapNuse') }}</title>

    {{-- FONT POPPINS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    @include('components.navbar')

    <main class="min-h-screen">
        @if (session('success'))
    <div class="w-full bg-green-500 text-white text-center py-3 mb-4">
        {{ session('success') }}
    </div>
@endif

        @yield('content')
    </main>

</body>
</html>

