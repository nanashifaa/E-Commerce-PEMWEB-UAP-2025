@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 md:px-8">

        {{-- JUDUL HALAMAN + KEMBALI --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                    Detail Pesanan
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Pesanan <span class="font-semibold text-gray-800">#{{ $order->code }}</span>
                </p>
            </div>
            <a href="{{ route('seller.orders.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-pink-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pesanan
            </a>
        </div>

        {{-- KARTU RINGKASAN --}}
        @php
            $rawStatus = $order->payment_status ?? $order->status ?? 'pending';

            $statusClass = match($rawStatus) {
                'pending'   => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                'paid'      => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                'completed','success','done' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                'cancelled','failed' => 'bg-red-50 text-red-700 ring-red-600/10',
                default     => 'bg-gray-50 text-gray-600 ring-gray-500/10',
            };

            // Label status Bahasa Indonesia
            $statusLabel = match($rawStatus) {
                'pending'   => 'Menunggu',
                'paid'      => 'Dibayar',
                'completed','success','done' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                'failed'    => 'Gagal',
                default     => ucfirst($rawStatus),
            };

            $buyerName   = optional($order->buyer)->name ?? 'Pelanggan';
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- KIRI: INFO PELANGGAN & PESANAN --}}
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                            Pelanggan
                        </p>
                        <div class="mt-1 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ strtoupper(substr($buyerName, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $buyerName }}</p>
                                <p class="text-xs text-gray-500">
                                    Tanggal pesanan:
                                    {{ $order->created_at?->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                Kode Pesanan
                            </p>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                #{{ $order->code }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                Status
                            </p>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: TOTAL & PENGIRIMAN --}}
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                            Total Pesanan
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                Jenis Pengiriman
                            </p>
                            <p class="mt-1 text-gray-800">
                                {{ $order->shipping_type ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Ongkir: Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                                Alamat Pengiriman
                            </p>
                            <p class="mt-1 text-gray-800 text-xs">
                                {{ $order->address }}<br>
                                {{ $order->city }} {{ $order->postal_code }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL ITEM --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900 text-base">
                    Item
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $order->details->count() }} item
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Produk</th>
                            <th class="px-6 py-3 font-semibold">Jumlah</th>
                            <th class="px-6 py-3 font-semibold">Harga</th>
                            <th class="px-6 py-3 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($order->details as $detail)
                            @php
                                $product  = $detail->product;
                                $name     = $product->name ?? 'Produk dihapus';
                                $price    = $product->price ?? 0;
                                $qty      = $detail->qty;
                                $subtotal = $detail->subtotal ?? ($price * $qty);
                            @endphp

                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 align-middle">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900">{{ $name }}</span>
                                        @if($product)
                                            <span class="text-xs text-gray-500">
                                                ID: {{ $product->id }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3 align-middle">
                                    <span class="text-gray-800 font-medium">{{ $qty }}</span>
                                </td>
                                <td class="px-6 py-3 align-middle">
                                    <span class="text-gray-800">
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 align-middle">
                                    <span class="font-semibold text-gray-900">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500 text-sm">
                                    Tidak ada item untuk pesanan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER RINCIAN TOTAL --}}
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-gray-50/60">
                <div class="text-xs text-gray-500">
                    * Semua harga sudah termasuk pajak (jika berlaku).
                </div>
                <div class="text-sm text-gray-700">
                    <div class="flex justify-between gap-6">
                        <span>Subtotal item</span>
                        {{-- Subtotal item = grand_total - shipping_cost - tax (kalau strukturmu cocok) --}}
                        <span class="font-semibold">
                            Rp {{ number_format(($order->grand_total - ($order->shipping_cost ?? 0) - ($order->tax ?? 0)), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-6">
                        <span>Ongkir</span>
                        <span class="font-semibold">
                            Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-6">
                        <span>Pajak</span>
                        <span class="font-semibold">
                            Rp {{ number_format($order->tax ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-6 border-t border-gray-200 mt-2 pt-2">
                        <span class="font-semibold text-gray-900">Total Akhir</span>
                        <span class="font-bold text-pink-600">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
