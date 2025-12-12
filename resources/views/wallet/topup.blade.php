<x-app-layout>
<style>
    body, * { font-family: 'Poppins', sans-serif !important; }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    {{-- HEADER --}}
    <div class="max-w-5xl mx-auto px-4 md:px-10 pt-10 pb-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Top Up Saldo
                </h1>
                <p class="text-gray-600 mt-2 text-sm md:text-base">
                    Tambahkan saldo dompet untuk melakukan transaksi.
                </p>
            </div>

            <a href="{{ session('topup_back_url', route('home')) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-gray-200
                      text-gray-700 hover:bg-gray-50 text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-5xl mx-auto px-4 md:px-10 pb-14">
        <div class="max-w-3xl mx-auto space-y-6">

            {{-- SALDO (ATAS) --}}
            <div class="bg-white rounded-2xl border border-pink-200 shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Saldo Saat Ini
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-pink-600 break-all leading-tight">
                        Rp {{ number_format($wallet->balance ?? 0, 0, ',', '.') }}
                    </p>

                    <div class="mt-4 rounded-xl bg-pink-50 border border-pink-200 px-4 py-3 text-sm text-pink-700">
                        <span class="font-semibold">Info:</span> Minimal top up <b>Rp 10.000</b>.
                    </div>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m2-4h-6m6 0l-2-2m2 2l-2 2"/>
                    </svg>
                </div>
            </div>

            {{-- FORM (BAWAH) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-pink-200 p-6 md:p-8">

                {{-- ERROR --}}
                @if($errors->any())
                    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('wallet.topup.submit') }}" class="space-y-5">
                    @csrf

                    {{-- NOMINAL --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nominal Top Up
                        </label>

                        <input type="number"
                               name="amount"
                               min="10000"
                               value="{{ old('amount') }}"
                               required
                               placeholder="Minimal Rp 10.000"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm
                                      focus:border-pink-500 focus:ring-pink-500">

                        <p class="text-xs text-gray-500 mt-1">
                            Minimal top up Rp 10.000
                        </p>
                    </div>

                    {{-- BANK --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Pilih Bank
                        </label>

                        <select name="bank"
                                required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm
                                       focus:border-pink-500 focus:ring-pink-500">
                            <option value="" disabled {{ old('bank') ? '' : 'selected' }}>— Pilih Bank —</option>
                            <option value="BCA" {{ old('bank')=='BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="BRI" {{ old('bank')=='BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="BNI" {{ old('bank')=='BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="MANDIRI" {{ old('bank')=='MANDIRI' ? 'selected' : '' }}>Mandiri</option>
                        </select>
                    </div>

                    {{-- INFO --}}
                    <div class="rounded-xl bg-pink-50 border border-pink-200 px-4 py-3 text-xs text-pink-700">
                        💡 Sistem akan membuat <strong>Virtual Account unik</strong> sesuai bank yang dipilih.
                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2
                                   px-6 py-3 rounded-full text-sm font-semibold text-white
                                   bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                        Generate VA Top Up
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                <p class="text-center text-xs text-gray-500 mt-6">
                    Pastikan nominal dan bank sudah benar sebelum melanjutkan.
                </p>
            </div>

        </div>
    </div>

</div>
</x-app-layout>
