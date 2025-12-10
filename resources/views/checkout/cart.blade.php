@extends('layouts.public')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-xl mb-4 max-w-4xl mx-auto mt-4 px-6">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif


<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- TITLE --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-semibold text-pink-600">
            Checkout Keranjang
        </h1>
        <p class="text-gray-700 mt-1">
            Periksa kembali pesanan Anda sebelum membayar
        </p>
    </div>

    {{-- PRODUCT LIST --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm mb-10">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Rincian Pesanan</h2>

        @foreach($carts as $cart)
        <div class="flex gap-6 mb-6">
            {{-- IMAGE --}}
            <div class="w-20 h-20 rounded-xl overflow-hidden bg-pink-100 flex-shrink-0">
                <img 
                    src="{{ asset('storage/' . ($cart->product->productImages->first()->image ?? 'default.jpg')) }}"
                    class="w-full h-full object-cover">
            </div>

            {{-- INFO --}}
            <div class="flex flex-col justify-center flex-1">
                <h2 class="text-base font-semibold text-gray-900 leading-tight">
                    {{ $cart->product->name }}
                </h2>

                <p class="text-xs text-gray-600 mt-1">
                    {{ $cart->product->store->name ?? '-' }} | {{ $cart->qty }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                </p>

                <p class="text-pink-600 font-bold mt-1 text-sm">
                    Rp {{ number_format($cart->qty * $cart->product->price, 0, ',', '.') }}
                </p>
            </div>
        </div>
        @endforeach
        
        <div class="border-t pt-4 flex justify-between items-center">
            <span class="font-semibold text-gray-700">Total Produk</span>
            <span class="font-bold text-xl text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- CHECKOUT FORM --}}
    <form action="{{ route('checkout.cart.process') }}" method="POST">
        @csrf

        {{-- ADDRESS --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Alamat Pengiriman</h3>

            <textarea name="address" required
                      class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
                      rows="3"
                      placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- CITY --}}
            <div class="bg-white p-6 rounded-2xl border shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Kota</h3>
                <input type="text" name="city" required
                       class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
                       placeholder="Contoh: Semarang">
            </div>

            {{-- POSTAL CODE --}}
            <div class="bg-white p-6 rounded-2xl border shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Kode Pos</h3>
                <input type="text" name="postal_code" required
                       class="w-full p-3 border rounded-xl bg-white focus:ring-2 focus:ring-pink-400 outline-none"
                       placeholder="Contoh: 50121">
            </div>
        </div>

        {{-- SHIPPING TYPE --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Metode Pengiriman (Per Toko)</h3>
            <p class="text-xs text-gray-500 mb-2">*Biaya pengiriman dihitung per toko (Total Transaksi)</p>

            <div class="space-y-2">
                <label class="flex items-center gap-3">
                    <input type="radio" name="shipping_type" value="regular" required
                           class="accent-pink-500">
                    <span class="text-gray-700">Regular (Rp 10.000 / toko)</span>
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio" name="shipping_type" value="express" class="accent-pink-500">
                    <span class="text-gray-700">Express (Rp 20.000 / toko)</span>
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
                    <span class="text-gray-700">Saldo (Wallet) - Saldo Anda: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="va"
                           class="accent-pink-500">
                    <span class="text-gray-700">Transfer Virtual Account (VA)</span>
                </label>
            </div>
        </div>

        {{-- SUBMIT BUTTON --}}
        <button type="submit"
                class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-lg font-medium shadow-md transition">
            Bayar Sekarang
        </button>

    </form>

</div>

@endsection
