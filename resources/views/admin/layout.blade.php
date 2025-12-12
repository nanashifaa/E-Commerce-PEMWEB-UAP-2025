<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        @include('admin.sidebar')

        {{-- Main content --}}
        <div class="flex-1 flex flex-col">

            {{-- Navbar --}}
            @include('admin.navbar')

            <main class="flex-1 px-8 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
