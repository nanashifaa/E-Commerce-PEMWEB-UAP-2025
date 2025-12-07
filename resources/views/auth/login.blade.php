<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #fdf2f8; /* Soft Pink */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center font-[Inter]">

<div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

    <h2 class="text-3xl font-semibold text-center text-gray-800">
        Welcome Back
    </h2>

    <p class="text-sm text-center text-gray-500 mb-6">
        Silakan login untuk melanjutkan
    </p>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
            @foreach ($errors->all() as $err)
                <p>{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
            <input 
                type="email" 
                name="email"
                required
                placeholder=""
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
            <input 
                type="password" 
                name="password"
                required
                placeholder=""
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- REMEMBER --}}
        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                Remember me
            </label>

            <a href="#" class="text-pink-600 text-sm hover:underline">
                Forgot Password?
            </a>
        </div>

        {{-- BUTTON --}}
        <button
            type="submit"
            class="w-full py-3 rounded-lg bg-pink-500 hover:bg-pink-600 text-white font-medium transition">
            Login
        </button>

        {{-- REGISTER --}}
        <p class="text-center text-sm text-gray-600 mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-pink-600 font-medium hover:underline">
                Daftar sekarang
            </a>
        </p>

    </form>

</div>

</body>
</html>
