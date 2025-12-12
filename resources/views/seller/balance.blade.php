@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Saldo Saya</h2>
                <p class="text-gray-500 mt-2">
                    Pantau saldo dan riwayat transaksi di toko Anda.
                </p>
            </div>

            {{-- TARIK DANA (AMAN) --}}
            <a href="{{ url('/seller/withdrawals') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-semibold
                      text-white bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                Tarik Dana
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- BALANCE CARD --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 p-6 md:p-8">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.16em]">
                        Total Saldo
                    </p>

                    <div class="mt-2">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">
                            Rp {{ number_format($balance->balance, 0, ',', '.') }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-2">
                            Saldo ini berasal dari riwayat transaksi toko Anda.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ url('/seller/withdrawals') }}"
                           class="inline-flex w-full items-center justify-center px-6 py-2.5 rounded-full text-sm font-semibold
                                  text-white bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                            Tarik Dana
                        </a>
                    </div>
                </div>
            </div>

            {{-- TRANSACTIONS TABLE --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Transaksi Terbaru</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Riwayat transaksi masuk dan keluar.
                            </p>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ method_exists($histories, 'total') ? $histories->total() : $histories->count() }} transaksi
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 border-b border-gray-100">
                                    <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Referensi
                                    </th>
                                    <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Tipe
                                    </th>
                                    <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-50">
                                @forelse ($histories as $history)
                                    @php
                                        $isCredit = in_array($history->type, ['credit', 'income']);

                                        $typePill = $isCredit
                                            ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
                                            : 'bg-red-50 text-red-700 ring-red-600/10';

                                        $typeLabel = $isCredit ? 'Masuk' : 'Keluar';
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="py-5 px-6 align-middle">
                                            <span class="text-sm text-gray-600">
                                                {{ $history->created_at?->format('d M Y, H:i') }}
                                            </span>
                                        </td>

                                        <td class="py-5 px-6 align-middle">
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $history->remarks ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="py-5 px-6 align-middle">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $typePill }}">
                                                {{ $typeLabel }}
                                            </span>
                                        </td>

                                        <td class="py-5 px-6 align-middle text-right">
                                            <span class="font-semibold {{ $isCredit ? 'text-emerald-700' : 'text-red-600' }}">
                                                {{ $isCredit ? '+' : '-' }}
                                                Rp {{ number_format($history->amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">Belum ada transaksi</p>
                                                <p class="text-sm text-gray-500">
                                                    Riwayat transaksi akan muncul setelah ada aktivitas.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION (kalau paginate) --}}
                    @if(method_exists($histories, 'hasPages') && $histories->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $histories->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
