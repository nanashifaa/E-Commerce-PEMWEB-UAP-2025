<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#fce8f4] p-8">

    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-md p-8 border border-pink-200">

        <h2 class="text-3xl font-semibold text-pink-600 mb-4">Top Up Saldo</h2>
        <p class="text-gray-600 mb-6">Masukkan nominal dan pilih bank untuk mendapatkan nomor VA unik.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('wallet.topup.submit') }}">
            @csrf

            {{-- Nominal --}}
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Nominal Top Up</label>
                <input type="number" name="amount" min="10000"
                       class="w-full p-3 mt-1 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400"
                       placeholder="Minimal 10.000" required>
            </div>

            {{-- Pilih Bank --}}
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Pilih Bank</label>
                <select name="bank"
                        class="w-full p-3 mt-1 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400"
                        required>
                    <option value="" disabled selected>Pilih Bank</option>
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="MANDIRI">MANDIRI</option>
                </select>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-lg shadow">
                Generate VA Top Up
            </button>

        </form>
    </div>

</div>

</x-app-layout>
