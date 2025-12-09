<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#fce8f4] p-8">

    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-md p-8 border border-pink-200">

        <h2 class="text-3xl font-semibold text-pink-600 mb-4">Top Up Berhasil Dibuat</h2>
        <p class="text-gray-600 mb-6">Gunakan kode VA berikut untuk menyelesaikan pembayaran.</p>

        {{-- Box VA --}}
        <div class="bg-pink-50 border border-pink-300 p-4 rounded-xl mb-6">
            <p class="text-gray-600 text-sm">Nomor Virtual Account</p>
            <p class="text-3xl font-bold text-pink-600">{{ $topup->va_number }}</p>

            <p class="text-gray-600 mt-3">Bank</p>
            <p class="text-xl font-semibold">{{ $topup->bank }}</p>

            <p class="text-gray-600 mt-3">Nominal Pembayaran</p>
            <p class="text-xl font-semibold text-gray-800">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
        </div>

        <p class="text-gray-500 text-sm mb-6">
            Setelah melakukan pembayaran melalui VA, saldo akan otomatis bertambah
            (karena sistem ini sudah dibuat tanpa persetujuan admin).
        </p>

        {{-- Tombol kembali --}}
        <a href="/wallet/topup"
           class="w-full block text-center py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-lg shadow">
            Top Up Lagi
        </a>

        {{-- Tombol konfirmasi otomatis untuk demo --}}
        <a href="{{ route('wallet.topup.confirm', $topup->id) }}"
           class="w-full block text-center py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow mt-3">
            Klik di sini jika sudah bayar (Auto Confirm)
        </a>

    </div>

</div>

</x-app-layout>
