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
            background: #fde7f2; /* pink soft pastel */
        }
    </style>
</head>

<body class="text-gray-900">

    @include('components.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

</body>
</html>

