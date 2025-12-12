@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- HEADER HALAMAN --}}
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Pesanan</h2>
                <p class="text-gray-500 mt-2">
                    Kelola dan pantau pesanan pelanggan Anda dengan mudah.
                </p>
            </div>
        </div>

        {{-- TABEL PESANAN --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100">
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Kode Pesanan
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse ($orders as $order)
                            @php
                                // ambil status dari payment_status dulu, kalau kosong baru ke status biasa
                                $rawStatus = $order->payment_status ?? $order->status ?? 'pending';

                                $statusClass = match($rawStatus) {
                                    'pending'   => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                    'paid'      => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                    'completed','success','done' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                    'cancelled','failed' => 'bg-red-50 text-red-700 ring-red-600/10',
                                    default     => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                };

                                // label status dalam Bahasa Indonesia
                                $statusLabel = match($rawStatus) {
                                    'pending'   => 'Menunggu',
                                    'paid'      => 'Dibayar',
                                    'completed','success','done' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    'failed'    => 'Gagal',
                                    default     => ucfirst($rawStatus),
                                };

                                $buyerName = optional($order->buyer)->name ?? 'Pelanggan';
                            @endphp

                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                {{-- Kode Pesanan --}}
                                <td class="py-5 px-6 align-middle">
                                    <span class="font-semibold text-gray-900">#{{ $order->code }}</span>
                                </td>

                                {{-- Pelanggan --}}
                                <td class="py-5 px-6 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ strtoupper(substr($buyerName, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700 font-medium">
                                            {{ $buyerName }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Total --}}
                                <td class="py-5 px-6 align-middle">
                                    <span class="font-bold text-gray-900">
                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="py-5 px-6 align-middle">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="py-5 px-6 align-middle">
                                    <span class="text-sm text-gray-500">
                                        {{ $order->created_at?->format('d M Y, H:i') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-5 px-6 text-right align-middle">
                                    <a href="{{ route('seller.orders.show', $order->id) }}"
                                       class="inline-flex items-center gap-1 text-sm font-medium text-pink-600 hover:text-pink-700 transition-colors">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                             fill="currentColor"
                                             class="w-4 h-4 transition-transform group-hover:translate-x-1">
                                            <path fill-rule="evenodd"
                                                  d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">Tidak ada pesanan</p>
                                        <p class="text-sm text-gray-500">
                                            Anda belum menerima pesanan apa pun.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINASI --}}
            @if(method_exists($orders, 'hasPages') && $orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
