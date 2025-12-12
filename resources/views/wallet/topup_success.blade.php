<x-app-layout>
<style>
    body, * { font-family: 'Poppins', sans-serif !important; }
</style>

<div class="min-h-screen bg-[#fce8f4] py-10">
    <div class="max-w-xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="mb-8 text-center">
            <div class="mx-auto w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h2 class="mt-4 text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                Top Up Berhasil Dibuat
            </h2>
            <p class="text-gray-600 mt-2 text-sm">
                Gunakan nomor Virtual Account (VA) berikut untuk menyelesaikan pembayaran.
            </p>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-200 overflow-hidden">

            {{-- VA BOX --}}
            <div class="p-6 md:p-8">
                <div class="rounded-2xl bg-pink-50 border border-pink-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nomor Virtual Account
                            </p>
                            <p id="vaText" class="mt-1 text-2xl md:text-3xl font-extrabold text-pink-600 tracking-tight">
                                {{ $topup->va_number }}
                            </p>
                        </div>

                        <button type="button" id="copyVaBtn"
                                class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full
                                       bg-white border border-pink-200 text-pink-700 text-sm font-semibold
                                       hover:bg-pink-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V8a2 2 0 00-2-2h-6l-4 4v10a2 2 0 002 2z"/>
                            </svg>
                            Salin
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5">
                        <div class="bg-white rounded-xl border border-gray-100 px-4 py-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Bank</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $topup->bank }}</p>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 px-4 py-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</p>
                            <p class="mt-1 text-sm font-extrabold text-gray-900">
                                Rp {{ number_format($topup->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- INFO --}}
                <div class="mt-5 rounded-xl bg-gray-50 border border-gray-100 px-4 py-3 text-sm text-gray-600">
                    Setelah melakukan pembayaran melalui VA, saldo akan otomatis bertambah
                    <span class="font-medium text-gray-800">(mode demo)</span>.
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="px-6 md:px-8 py-5 bg-gray-50 border-t border-gray-100 space-y-3">
                <a href="{{ route('wallet.topup') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full
                          bg-pink-600 hover:bg-pink-700 text-white font-semibold shadow-lg shadow-pink-400/30 transition">
                    Top Up Lagi
                </a>

                <a href="{{ route('wallet.topup.confirm', $topup->id) }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full
                          bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-lg shadow-emerald-400/25 transition">
                    Saya Sudah Bayar
                </a>

                <p id="copyHint" class="text-center text-xs text-gray-500 hidden">
                    Nomor VA berhasil disalin ✅
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const copyBtn = document.getElementById('copyVaBtn');
    const vaText = document.getElementById('vaText');
    const hint = document.getElementById('copyHint');

    if (copyBtn && vaText) {
        copyBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(vaText.innerText.trim());
                if (hint) {
                    hint.classList.remove('hidden');
                    setTimeout(() => hint.classList.add('hidden'), 2000);
                }
            } catch (e) {
                alert('Gagal menyalin VA. Silakan salin manual.');
            }
        });
    }
</script>
</x-app-layout>
