<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-pink-50 py-10">

    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-pink-200">

        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">
            Top Up Wallet
        </h2>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM TOPUP --}}
        <form action="{{ route('wallet.topup.process') }}" method="POST">
            @csrf

            {{-- Amount --}}
            <label class="block text-gray-700 font-medium mb-2">Nominal Top Up</label>
            <input type="number" name="amount" min="1000" required
                   class="w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400 mb-5"
                   placeholder="Masukkan jumlah top up">

            {{-- Payment Method --}}
            <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>
            <select name="bank"
                class="w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400 mb-8">

                <option value="bca">Bank BCA</option>
                <option value="bri">Bank BRI</option>
                <option value="bni">Bank BNI</option>
                <option value="mandiri">Bank Mandiri</option>
            </select>

            <button type="submit"
                class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-xl shadow">
                Top Up Sekarang
            </button>
        </form>

        {{-- Wallet balance section --}}
        <div class="mt-8 bg-pink-100 p-5 rounded-xl border border-pink-200">
            <p class="text-gray-600">Saldo saat ini:</p>
            <h3 class="text-3xl font-semibold text-pink-600">
                Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}
            </h3>
        </div>

    </div>

</div>

</x-app-layout>
