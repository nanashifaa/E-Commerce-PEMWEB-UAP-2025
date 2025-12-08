<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#ffe5ef]">

    {{-- TOPBAR --}}
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">User Dashboard</h1>

        <div class="flex items-center gap-3">
            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <img src="https://i.pravatar.cc/100"
                 class="w-10 h-10 rounded-full border border-pink-300 shadow-sm">
        </div>
    </header>

    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="w-56 min-h-screen bg-white border-r p-6 space-y-5 hidden md:block">

            <a href="/dashboard" class="block text-pink-600 font-semibold">Dashboard</a>
            <a href="/history" class="block text-gray-600 hover:text-pink-600">Order History</a>
            <a href="/wallet/topup" class="block text-gray-600 hover:text-pink-600">Top Up Wallet</a>
            <a href="/profile" class="block text-gray-600 hover:text-pink-600">Profile</a>

            <form method="POST" action="{{ route('logout') }}" class="pt-10">
                @csrf
                <button class="text-gray-500 hover:text-red-500">Logout</button>
            </form>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-10">

            {{-- WELCOME --}}
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">
                    Welcome, {{ Auth::user()->name }} 💕
                </h2>
                <p class="text-gray-500">Happy shopping on our cute marketplace!</p>
            </div>

            {{-- USER STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm">
                    <p class="text-sm text-gray-500">Your Balance</p>
                    <h3 class="text-3xl font-semibold text-pink-600 mt-2">Rp 150.000</h3>
                </div>

                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <h3 class="text-3xl font-semibold mt-2">12</h3>
                </div>

                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm">
                    <p class="text-sm text-gray-500">Pending Deliveries</p>
                    <h3 class="text-3xl font-semibold text-yellow-600 mt-2">3</h3>
                </div>

            </div>

            {{-- RECOMMENDED PRODUCTS --}}
            <div class="mt-14">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Recommended for You</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                    {{-- Dummy product card --}}
                    @foreach (range(1,4) as $i)
                    <div class="bg-white p-4 rounded-xl shadow border border-pink-100">
                        <img src="https://via.placeholder.com/200"
                             class="rounded-lg mb-3 shadow-sm">

                        <h4 class="font-semibold text-gray-800">Cute Pink Outfit {{ $i }}</h4>
                        <p class="text-pink-600 font-medium">Rp 120.000</p>

                        <button class="mt-3 w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg">
                            Add to Cart
                        </button>
                    </div>
                    @endforeach

                </div>
            </div>

        </main>

    </div>

</div>

</x-app-layout>
