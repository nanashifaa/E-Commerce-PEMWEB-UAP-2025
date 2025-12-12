<x-app-layout>

    {{-- NAVBAR (samakan dengan yang kamu pakai di index) --}}
    @include('components.navbar')

    <div class="min-h-screen bg-[#fce8f4] py-10">
        <div class="max-w-5xl mx-auto px-4 md:px-10">

            {{-- HEADER + BACK --}}
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                        Detail Transaksi
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Kode transaksi:
                        <span class="font-semibold text-gray-900">{{ $transaction->code }}</span>
                    </p>
                </div>

                <a href="{{ route('history.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-200 bg-white
                          text-gray-700 hover:bg-gray-50 text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            @php
                $paid = ($transaction->payment_status ?? null) === 'paid';

                $statusClass = $paid
                    ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
                    : 'bg-amber-50 text-amber-700 ring-amber-600/20';

                $statusLabel = $paid
                    ? 'Paid'
                    : ucfirst($transaction->payment_status ?? 'Pending');

                $itemCount = $transaction->transactionDetails?->count() ?? 0;
            @endphp

            {{-- SUMMARY CARD --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 mb-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">

                    {{-- LEFT --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>

                            <span class="text-xs text-gray-500">
                                ID: <span class="font-medium text-gray-700">{{ $transaction->id }}</span>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl border border-gray-100 px-4 py-3">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Toko
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $transaction->store->name ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-xl border border-gray-100 px-4 py-3">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </p>
                                <p class="mt-1 text-sm font-medium text-gray-900">
                                    {{ optional($transaction->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="md:text-right">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Total Pembayaran
                        </p>
                        <p class="mt-1 text-3xl font-extrabold text-pink-600">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            Total item: <span class="font-semibold text-gray-800">{{ $itemCount }}</span>
                        </p>
                    </div>

                </div>
            </div>

            {{-- ITEMS CARD --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-base md:text-lg font-bold text-gray-900">
                        Produk Dibeli
                    </h2>
                    <span class="text-xs text-gray-500">
                        {{ $itemCount }} item
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 md:px-8 py-3 font-semibold">Produk</th>
                                <th class="px-6 md:px-8 py-3 font-semibold">Qty</th>
                                <th class="px-6 md:px-8 py-3 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transaction->transactionDetails as $detail)
                                @php
                                    $productName = $detail->product->name ?? 'Produk sudah dihapus';
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 md:px-8 py-4">
                                        <p class="font-semibold text-gray-900">
                                            {{ $productName }}
                                        </p>
                                        @if($detail->product?->id)
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                ID Produk: {{ $detail->product->id }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-6 md:px-8 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $detail->qty }}
                                        </span>
                                    </td>

                                    <td class="px-6 md:px-8 py-4 text-right font-bold text-gray-900">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 md:px-8 py-10 text-center text-gray-500">
                                        Tidak ada detail produk pada transaksi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div class="px-6 md:px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-500">
                        * Semua harga sudah termasuk biaya yang berlaku (jika ada).
                    </p>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Grand Total</p>
                        <p class="text-lg font-extrabold text-pink-600">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
