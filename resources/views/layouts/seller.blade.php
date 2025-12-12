<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Panel - {{ config('app.name', 'Cheap n Use') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    {{-- NAVBAR KHUSUS SELLER --}}
    @include('components.seller-navbar')

    {{-- KONTEN HALAMAN --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
