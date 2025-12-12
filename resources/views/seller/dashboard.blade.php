@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- PESAN SAMBUTAN --}}
        <div class="mb-10 text-center md:text-left">
            <h2 class="text-3xl font-bold text-gray-800">
                Halo, {{ Auth::user()->name }}
            </h2>
            <p class="text-gray-500 mt-1">
                Berikut yang terjadi di toko Anda hari ini.
            </p>
        </div>

        {{-- KALAU BELUM PUNYA TOKO --}}
        @if(!$store)
            <div class="mb-10 bg-pink-100 border border-pink-300 text-pink-700 p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold">Anda belum memiliki toko</h3>
                    <p class="text-sm mt-1">
                        Daftarkan toko Anda untuk mulai menjual produk kepada ribuan pelanggan kami.
                    </p>
                </div>
                <a href="{{ route('store.register') }}"
                   class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition">
                    Daftarkan Toko Sekarang
                </a>
            </div>

            <div class="mb-10 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">
                <p class="text-gray-700 text-sm">
                    Statistik dan pesanan terbaru akan muncul setelah Anda mendaftarkan toko.
                </p>
            </div>

        @else
            {{-- INFO TOKO --}}
            <div class="mb-10 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $store->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-sm text-gray-500">Status:</span>
                            @if($store->is_verified)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Terverifikasi
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- KALAU BELUM VERIFIED --}}
            @if(!$store->is_verified)
                <div class="mb-10 bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-2xl shadow-sm">
                    <p class="text-sm">
                        Akun seller Anda belum terverifikasi. Mohon menunggu persetujuan admin sebelum dapat melihat statistik dan pesanan terbaru.
                    </p>
                </div>

            @else
                {{-- GRID STATISTIK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalOrders ?? 0 }}</h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-sm text-gray-500">Pendapatan</p>
                        <h3 class="text-3xl font-bold mt-2">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-sm text-gray-500">Produk Aktif</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $activeProducts }}</h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-sm text-gray-500">Pesanan Menunggu</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $pendingOrders }}</h3>
                    </div>
                </div>

                {{-- TABEL PESANAN TERBARU --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between">
                        <h3 class="font-bold text-lg">Pesanan Terbaru</h3>
                        <a href="{{ route('seller.orders.index') }}"
                           class="text-pink-600 text-sm font-semibold hover:underline">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                                <tr>
                                    <th class="px-8 py-4 text-left">ID Pesanan</th>
                                    <th class="px-8 py-4 text-left">Pelanggan</th>
                                    <th class="px-8 py-4 text-left">Total</th>
                                    <th class="px-8 py-4 text-left">Status</th>
                                    <th class="px-8 py-4 text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($latestOrders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-8 py-4 font-semibold">#{{ $order->code }}</td>
                                        <td class="px-8 py-4">{{ $order->buyer->name ?? 'Pelanggan' }}</td>
                                        <td class="px-8 py-4 font-semibold">
                                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-8 py-4">
                                            <span class="px-3 py-1 text-xs rounded-full
                                                {{ $order->payment_status === 'paid'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <a href="{{ route('seller.orders.show', $order->id) }}"
                                               class="inline-block px-4 py-2 text-sm font-semibold rounded-xl
                                                      bg-pink-50 text-pink-600 hover:bg-pink-100 transition">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-6 text-center text-gray-500">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection
