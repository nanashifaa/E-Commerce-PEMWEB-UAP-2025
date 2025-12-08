<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - App</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- TAMBAHAN: CSRF META UNTUK KEAMANAN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #fdf2f8; /* Soft Pink */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center font-[Inter]">

<div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

    <h2 class="text-3xl font-semibold text-center text-gray-800">
        Create Account
    </h2>

    <p class="text-sm text-center text-gray-500 mb-6">
        Join our fashion community
    </p>

    {{-- TAMBAHAN: TAMPILKAN ERROR VALIDASI JIKA ADA --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- ROLE DROPDOWN --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Register as</label>
            <select 
                name="role" 
                required
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
                <option value="" disabled selected>Pilih peran</option>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>
        </div>

        {{-- NAME --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
            <input 
                type="text" 
                name="name" 
                required
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
            <input 
                type="email" 
                name="email" 
                required
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
            <input 
                type="password" 
                name="password" 
                required
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                required
                class="w-full p-3 rounded-lg border border-gray-300 bg-pink-50/40 focus:ring-2 focus:ring-pink-300 transition">
        </div>

        {{-- SUBMIT BUTTON --}}
        <button 
            type="submit"
            class="w-full py-3 rounded-lg bg-pink-500 hover:bg-pink-600 text-white font-medium transition shadow-sm">
            Create Account
        </button>

        <p class="text-center text-sm text-gray-600 mt-5">
            Already have an account?
            <a href="{{ route('login') }}" class="text-pink-600 font-medium hover:underline">
                Login
            </a>
        </p>

    </form>
</div>

</body>
</html>
