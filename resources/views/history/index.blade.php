<x-app-layout>

    {{-- NAVBAR --}}
    @include('components.navbar')

    <div class="min-h-screen bg-[#fce8f4] py-10">
        <div class="max-w-5xl mx-auto px-4 md:px-10">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                        Riwayat Transaksi
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Pantau semua transaksi yang pernah kamu lakukan.
                    </p>
                </div>

                <div class="text-sm text-gray-600">
                    Total:
                    <span class="font-semibold text-gray-900">
                        {{ $transactions->count() }}
                    </span>
                    transaksi
                </div>
            </div>

            {{-- EMPTY STATE --}}
            @if ($transactions->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-2a4 4 0 014-4h2M9 7h.01M15 7h.01M12 21a9 9 0 110-18 9 9 0 010 18z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">
                        Belum ada transaksi
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Kamu belum melakukan transaksi. Yuk mulai belanja!
                    </p>

                    <a href="{{ route('home') }}"
                       class="inline-flex mt-5 px-6 py-2.5 rounded-full bg-pink-600
                              text-white text-sm font-semibold hover:bg-pink-700 transition">
                        Jelajahi Produk
                    </a>
                </div>
            @else

                {{-- LIST TRANSAKSI --}}
                <div class="space-y-4">
                    @foreach ($transactions as $trx)
                        @php
                            $paid = $trx->payment_status === 'paid';

                            $badgeClass = $paid
                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
                                : 'bg-amber-50 text-amber-700 ring-amber-600/20';

                            $badgeText = $paid ? 'Paid' : ucfirst($trx->payment_status);
                        @endphp

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">
                            <div class="p-6 md:p-7">
                                <div class="flex flex-col md:flex-row md:justify-between gap-5">

                                    {{-- LEFT --}}
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-3">
                                            <p class="text-sm text-gray-500">Kode Transaksi</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                                         text-xs font-semibold ring-1 ring-inset {{ $badgeClass }}">
                                                {{ $badgeText }}
                                            </span>
                                        </div>

                                        <p class="text-xl font-bold text-gray-900">
                                            {{ $trx->code }}
                                        </p>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                            <div class="bg-gray-50 rounded-xl border border-gray-100 px-4 py-3">
                                                <p class="text-xs font-semibold text-gray-500 uppercase">
                                                    Toko
                                                </p>
                                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                                    {{ $trx->store->name }}
                                                </p>
                                            </div>

                                            <div class="bg-gray-50 rounded-xl border border-gray-100 px-4 py-3">
                                                <p class="text-xs font-semibold text-gray-500 uppercase">
                                                    Total
                                                </p>
                                                <p class="mt-1 text-sm font-bold text-pink-600">
                                                    Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- RIGHT --}}
                                    <div class="flex md:flex-col gap-3 md:items-end md:justify-between">
                                        <a href="{{ route('history.show', $trx->id) }}"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                                                  bg-pink-600 text-white text-sm font-semibold
                                                  hover:bg-pink-700 transition">
                                            Lihat Detail
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>

                                        <p class="text-xs text-gray-500 md:text-right">
                                            Dibuat:
                                            <span class="font-medium text-gray-700">
                                                {{ $trx->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </p>
                                    </div>

                                </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="px-6 md:px-7 py-3 bg-gray-50 border-t border-gray-100
                                        flex items-center justify-between text-xs text-gray-600">
                                <span>ID: <span class="font-medium text-gray-800">{{ $trx->id }}</span></span>
                                <span class="hidden sm:inline">
                                    Status: <span class="font-semibold text-gray-800">{{ $badgeText }}</span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif

        </div>
    </div>

</x-app-layout>
