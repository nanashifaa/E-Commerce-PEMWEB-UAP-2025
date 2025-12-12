<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, * { font-family: 'Poppins', sans-serif !important; }
    </style>
</head>

<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    {{-- PAGE HEADING --}}
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- TOAST SUCCESS --}}
    @if (session('success'))
        <div id="toast-success"
             class="fixed top-5 right-5 z-[9999] bg-green-50 border border-green-200 text-green-700
                    px-4 py-3 rounded-xl shadow-lg flex items-start gap-3">
            <svg class="h-5 w-5 mt-0.5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm font-medium">{{ session('success') }}</div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('toast-success');
                if (el) el.remove();
            }, 3000);
        </script>
    @endif

    {{-- TOAST ERROR --}}
    @if (session('error'))
        <div id="toast-error"
             class="fixed top-5 right-5 z-[9999] bg-red-50 border border-red-200 text-red-700
                    px-4 py-3 rounded-xl shadow-lg flex items-start gap-3">
            <svg class="h-5 w-5 mt-0.5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 102 0V7zm0 6a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm font-medium">{{ session('error') }}</div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('toast-error');
                if (el) el.remove();
            }, 3000);
        </script>
    @endif

    <main>
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>
</div>
</body>
</html>
