@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Penarikan Dana</h2>
                <p class="text-gray-500 mt-2">
                    Ajukan penarikan dana dan pantau riwayatnya.
                </p>
            </div>

            {{-- KEMBALI (AMAN) --}}
            <a href="{{ url('/seller/balance') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                      border border-gray-200 bg-white text-gray-700
                      hover:bg-gray-50 text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Saldo</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    Rp {{ number_format($computedBalance, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Dihitung dari riwayat transaksi</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pemasukan</p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Akumulasi pemasukan</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Penarikan</p>
                <p class="mt-2 text-2xl font-bold text-pink-600">
                    Rp {{ number_format($totalWithdrawals, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Penarikan yang tercatat</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: FORM --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- AVAILABLE BALANCE --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Saldo Tersedia
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900">
                        Rp {{ number_format($balance->balance, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        Pastikan data rekening sesuai.
                    </p>
                </div>

                {{-- FORM --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-lg">Ajukan Penarikan</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Isi detail rekening dan jumlah penarikan.
                        </p>
                    </div>

                    <div class="p-6">
                        {{-- ERROR --}}
                        @if ($errors->any())
                            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url('/seller/withdrawals') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nama Bank
                                </label>
                                <select name="bank_name" required
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                               focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BNI">BNI</option>
                                    <option value="MANDIRI">Mandiri</option>
                                    <option value="BSI">BSI</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nomor Rekening
                                </label>
                                <input type="text" name="account_number" required
                                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                              focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nama Pemilik Rekening
                                </label>
                                <input type="text" name="account_name" required
                                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                              focus:border-pink-500 focus:ring-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Jumlah (Rp)
                                </label>
                                <input type="number" name="amount" min="10000" required
                                       class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                              focus:border-pink-500 focus:ring-pink-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Minimal penarikan Rp 10.000
                                </p>
                            </div>

                            <button type="submit"
                                    class="w-full px-6 py-2.5 rounded-full text-sm font-semibold
                                           text-white bg-pink-600 hover:bg-pink-700
                                           shadow-lg shadow-pink-400/30 transition">
                                Kirim Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RIGHT: HISTORY --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-lg">Riwayat Penarikan</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Status pengajuan penarikan dana.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Rekening</th>
                                    <th class="px-6 py-3">Jumlah</th>
                                    <th class="px-6 py-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($withdrawals as $w)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $w->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <p class="font-medium text-gray-800">{{ $w->bank_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $w->bank_account_number }} — {{ $w->bank_account_name }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">
                                            Rp {{ number_format($w->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($w->status === 'pending')
                                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                    Menunggu
                                                </span>
                                            @elseif($w->status === 'approved')
                                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                    Disetujui
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-gray-400">
                                            Belum ada pengajuan penarikan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
