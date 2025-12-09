<x-app-layout>

    <style>
        body, * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

    <div class="min-h-screen bg-[#fce8f4] py-10">

        <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-pink-200 p-8 space-y-6">

            <h1 class="text-2xl font-semibold text-gray-800">
                Topup Diajukan
            </h1>

            <p class="text-gray-600 text-sm">
                Silakan lakukan pembayaran ke nomor Virtual Account berikut
                sebelum batas waktu yang ditentukan oleh sistem pembayaran.
            </p>

            <div class="bg-pink-50 border border-pink-200 rounded-xl px-5 py-4 space-y-2">
                <p class="text-sm text-gray-600">Bank</p>
                <p class="text-lg font-semibold text-gray-800">
                    {{ $topup->bank }}
                </p>

                <p class="text-sm text-gray-600 mt-3">Nomor Virtual Account</p>
                <p class="text-2xl font-bold text-pink-600 tracking-widest">
                    {{ $topup->va_number }}
                </p>

                <p class="text-sm text-gray-600 mt-3">Nominal</p>
                <p class="text-xl font-semibold text-gray-800">
                    Rp {{ number_format($topup->amount, 0, ',', '.') }}
                </p>

                <p class="text-xs text-gray-500 mt-3">
                    Status: <span class="font-semibold text-yellow-600 uppercase">{{ $topup->status }}</span>
                </p>
            </div>

            <a href="/wallet/topup"
               class="inline-block text-sm text-pink-600 font-medium hover:underline">
                Buat pengajuan topup lain
            </a>

        </div>

    </div>

</x-app-layout>
