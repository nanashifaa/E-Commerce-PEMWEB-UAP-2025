@extends('layouts.public')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-xl mb-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif


<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- TITLE --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-semibold text-pink-600">
            Checkout Produk
        </h1>
        <p class="text-gray-700 mt-1">
            Selesaikan pesananmu dengan mudah ✨
        </p>
    </div>

    {{-- PRODUCT SUMMARY --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm mb-10">

        <div class="flex gap-6">
            {{-- IMAGE --}}
            <div class="w-32 h-32 rounded-xl overflow-hidden bg-pink-100">
                <img 
                    src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}"
                    class="w-full h-full object-cover">
            </div>

            {{-- INFO --}}
            <div class="flex flex-col justify-center">
                <h2 class="text-xl font-semibold text-gray-900 leading-tight">
                    {{ $product->name }}
                </h2>

                <p class="text-sm text-gray-600 mt-1">
                    {{ $product->store->name ?? '-' }}
                </p>

                <p class="text-pink-600 font-bold mt-3 text-lg">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- CHECKOUT FORM --}}
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        {{-- ADDRESS --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Alamat Pengiriman</h3>

            <textarea name="address" required
                      class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
                      rows="3"
                      placeholder="Masukkan alamat lengkap"></textarea>
        </div>
        {{-- CITY --}}
<div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-3">Kota</h3>
    <input type="text" name="city" required
           class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
           placeholder="Contoh: Semarang">
</div>

{{-- POSTAL CODE --}}
<div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-3">Kode Pos</h3>
    <input type="text" name="postal_code" required
           class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
           placeholder="Contoh: 50121">
</div>

        {{-- SHIPPING TYPE --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Metode Pengiriman</h3>

            <div class="space-y-2">
                <label class="flex items-center gap-3">
                    <input type="radio" name="shipping_type" value="regular" required
                           class="accent-pink-500">
                    <span class="text-gray-700">Regular (Rp 10.000)</span>
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio" name="shipping_type" value="express" class="accent-pink-500">
                    <span class="text-gray-700">Express (Rp 20.000)</span>
                </label>
            </div>
        </div>

        {{-- PAYMENT METHOD --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm mb-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Metode Pembayaran</h3>

            <div class="space-y-2">
                <label class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="wallet" required
                           class="accent-pink-500">
                    <span class="text-gray-700">Saldo (Wallet)</span>
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="va"
                           class="accent-pink-500">
                    <span class="text-gray-700">Transfer Virtual Account (VA)</span>
                </label>
            </div>
        </div>

        {{-- HIDDEN PRODUCT --}}
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        {{-- SUBMIT BUTTON --}}
        <button type="submit"
                class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-lg font-medium shadow-md transition">
            Lanjutkan Pembayaran
        </button>

    </form>

</div>

@endsection
