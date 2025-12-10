@extends('layouts.public')

@section('content')

{{-- SELLER HEADER & NAV --}}
<div class="bg-white border-b sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 md:px-10">
        <div class="flex flex-col md:flex-row items-center justify-between py-4 gap-4">
            
            {{-- User Info --}}
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xl border border-pink-200">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Seller Dashboard</h1>
                    <p class="text-xs text-gray-500">{{ Auth::user()->name }}</p>
                </div>
            </div>

            {{-- Horizontal Menu --}}
            <nav class="flex gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide w-full md:w-auto">
                <a href="/seller/dashboard" class="px-5 py-2 rounded-full bg-pink-600 text-white font-medium text-sm transition shadow-sm whitespace-nowrap">Dashboard</a>
                <a href="/seller/orders" class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 font-medium text-sm hover:bg-pink-50 hover:text-pink-600 transition whitespace-nowrap">Orders</a>
                <a href="/seller/products" class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 font-medium text-sm hover:bg-pink-50 hover:text-pink-600 transition whitespace-nowrap">Products</a>
                <a href="/seller/categories" class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 font-medium text-sm hover:bg-pink-50 hover:text-pink-600 transition whitespace-nowrap">Categories</a>
                <a href="/seller/balance" class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 font-medium text-sm hover:bg-pink-50 hover:text-pink-600 transition whitespace-nowrap">Balance</a>
                <a href="/seller/withdrawals" class="px-5 py-2 rounded-full bg-gray-100 text-gray-600 font-medium text-sm hover:bg-pink-50 hover:text-pink-600 transition whitespace-nowrap">Withdrawals</a>
            </nav>
        </div>
    </div>
</div>

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- WELCOME MESSAGE --}}
        <div class="mb-10 text-center md:text-left">
            <h2 class="text-3xl font-bold text-gray-800">
                Hello, {{ Auth::user()->name }} 👋
            </h2>
            <p class="text-gray-500 mt-1">Here is what's happening in your store today.</p>
        </div>

        {{-- STORE STATUS ALERT --}}
        @if(!$store)
        <div class="mb-10 bg-pink-100 border border-pink-300 text-pink-700 p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold">Kamu belum memiliki toko</h3>
                <p class="text-sm mt-1">Daftarkan toko kamu untuk mulai menjual produk kepada ribuan pelanggan kami.</p>
            </div>
            <a href="/store/register" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition">
                Daftarkan Toko Sekarang
            </a>
        </div>
        @else
        <div class="mb-10 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $store->name }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                         <span class="text-sm text-gray-500">Status:</span>
                        @if($store->is_verified)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending Verification
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Edit Button could go here --}}
        </div>
        @endif

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            
            {{-- Card 1 --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-gray-500 font-medium text-sm">Total Orders</p>
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">178</h3>
                <p class="text-xs text-green-500 mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +12% from last month
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                <div class="flex items-center justify-between mb-4">
                     <p class="text-gray-500 font-medium text-sm">Revenue</p>
                    <div class="w-8 h-8 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">Rp 12.450.000</h3>
                <p class="text-xs text-green-500 mt-2 flex items-center gap-1">
                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +5.4% from last month
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                 <div class="flex items-center justify-between mb-4">
                    <p class="text-gray-500 font-medium text-sm">Active Products</p>
                     <div class="w-8 h-8 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">42</h3>
                <p class="text-xs text-gray-400 mt-2">In 8 Categories</p>
            </div>

            {{-- Card 4 --}}
             <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                 <div class="flex items-center justify-between mb-4">
                    <p class="text-gray-500 font-medium text-sm">Pending Orders</p>
                     <div class="w-8 h-8 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center group-hover:scale-110 transition">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">6</h3>
                 <p class="text-xs text-yellow-600 mt-2 font-medium">Needs Action</p>
            </div>
        </div>

        {{-- LATEST ORDERS TABLE --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-lg">Latest Orders</h3>
                <a href="/seller/orders" class="text-pink-600 text-sm font-medium hover:text-pink-700">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-8 py-4 font-semibold">Order ID</th>
                            <th class="px-8 py-4 font-semibold">Customer</th>
                            <th class="px-8 py-4 font-semibold">Total</th>
                            <th class="px-8 py-4 font-semibold">Status</th>
                            <th class="px-8 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-8 py-4 font-medium text-gray-900">#TRX-001</td>
                            <td class="px-8 py-4 text-gray-600">Aulia Rahma</td>
                            <td class="px-8 py-4 font-medium text-gray-900">Rp 250.000</td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                    Pending
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <button class="text-gray-400 hover:text-pink-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </td>
                        </tr>
                         <tr class="hover:bg-gray-50 transition">
                            <td class="px-8 py-4 font-medium text-gray-900">#TRX-002</td>
                            <td class="px-8 py-4 text-gray-600">Nadya Putri</td>
                            <td class="px-8 py-4 font-medium text-gray-900">Rp 480.000</td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                    Completed
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <button class="text-gray-400 hover:text-pink-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
