<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    {{-- TOPBAR --}}
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>

        <div class="flex items-center gap-3">
            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <img src="https://i.pravatar.cc/100"
                 class="w-10 h-10 rounded-full border border-pink-300 shadow-sm">
        </div>
    </header>

    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="w-60 min-h-screen bg-white border-r p-6 space-y-5 hidden md:block">

            <a href="/dashboard" class="block text-pink-600 font-semibold">Dashboard</a>
            <a href="/seller/orders" class="block text-gray-600 hover:text-pink-600">Orders</a>
            <a href="/seller/products" class="block text-gray-600 hover:text-pink-600">Products</a>
            <a href="/seller/categories" class="block text-gray-600 hover:text-pink-600">Categories</a>
            <a href="/seller/balance" class="block text-gray-600 hover:text-pink-600">Balance</a>
            <a href="/seller/withdrawals" class="block text-gray-600 hover:text-pink-600">Withdrawals</a>

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
                    Hello, {{ Auth::user()->name }} 👋
                </h2>
                <p class="text-gray-500">Welcome back to your fashion dashboard</p>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">

                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <h3 class="text-3xl font-semibold mt-2">178</h3>
                </div>

              <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-gray-500 mb-1">Revenue</p>
                    <h3 class="text-3xl font-semibold text-pink-600 leading-tight">
                       Rp. 12.450.000
                    </h3>
            </div>
                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Products</p>
                    <h3 class="text-3xl font-semibold mt-2">42</h3>
                </div>

                <div class="bg-white p-6 rounded-xl border border-pink-200 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Pending Orders</p>
                    <h3 class="text-3xl font-semibold text-yellow-600 mt-2">6</h3>
                </div>

            </div>

            {{-- LATEST ORDERS --}}
            <div class="mt-14">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Latest Orders</h3>

                <div class="bg-white rounded-xl border border-pink-200 shadow-sm p-6">

                    <table class="w-full text-left">
                        <thead class="text-gray-500 text-sm border-b">
                            <tr>
                                <th class="py-3">Order Code</th>
                                <th class="py-3">Customer</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr class="border-b">
                                <td class="py-3">TRX001</td>
                                <td class="py-3">Aulia Rahma</td>
                                <td class="py-3">Rp 250.000</td>
                                <td class="py-3">
                                    <span class="px-3 py-1 text-xs rounded-lg bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3">TRX002</td>
                                <td class="py-3">Nadya Putri</td>
                                <td class="py-3">Rp 480.000</td>
                                <td class="py-3">
                                    <span class="px-3 py-1 text-xs rounded-lg bg-green-100 text-green-700">
                                        Completed
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>

        </main>

    </div>
{{-- STORE STATUS / REGISTER STORE --}}
@if(!$store)
    <div class="mt-6 bg-pink-100 border border-pink-300 text-pink-700 p-5 rounded-xl">
        <h3 class="text-lg font-semibold">Kamu belum memiliki toko</h3>
        <p class="text-sm mt-1">Daftarkan toko kamu untuk mulai menjual produk.</p>

        <a href="/store/register"
           class="inline-block mt-3 bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg shadow">
            Daftarkan Toko
        </a>
    </div>
@else
    <div class="mt-6 bg-green-100 border border-green-300 text-green-700 p-5 rounded-xl">
        <h3 class="text-lg font-semibold">Status Toko: 
            @if($store->is_verified)
                <span class="text-green-600">Terverifikasi</span>
            @else
                <span class="text-yellow-600">Menunggu Verifikasi Admin</span>
            @endif
        </h3>
        <p class="text-sm mt-1">{{ $store->name }}</p>
    </div>
@endif

</div>

</x-app-layout>
