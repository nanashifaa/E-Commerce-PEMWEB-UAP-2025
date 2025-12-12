@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- GLOBAL ERROR --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6">
            <p class="font-semibold mb-2">Ada yang perlu diperbaiki:</p>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TITLE --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-semibold text-gray-900">
            Checkout <span class="text-pink-600">Keranjang</span>
        </h1>
        <p class="text-gray-600 mt-2">
            Periksa kembali pesanan Anda sebelum membayar
        </p>
    </div>

    {{-- PRODUCT LIST --}}
    <div class="bg-white p-6 rounded-2xl border shadow-sm mb-10">
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Rincian Pesanan</h2>
            <span class="text-sm text-gray-500">{{ $carts->count() }} item</span>
        </div>

        <div class="space-y-4">
            @foreach($carts as $cart)
                <div class="flex items-start gap-4">
                    {{-- IMAGE --}}
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-pink-100 flex-shrink-0">
                        <img
                            src="{{ asset('storage/' . ($cart->product->productImages->first()->image ?? 'default.jpg')) }}"
                            class="w-full h-full object-cover"
                            alt="{{ $cart->product->name }}"
                        >
                    </div>

                    {{-- INFO --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-900 leading-tight">
                                    {{ $cart->product->name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $cart->product->store->name ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ $cart->qty }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <p class="font-bold text-pink-600">
                                Rp {{ number_format($cart->qty * $cart->product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if(!$loop->last)
                    <div class="border-t"></div>
                @endif
            @endforeach
        </div>

        <div class="border-t mt-5 pt-4 flex justify-between items-center">
            <span class="font-semibold text-gray-700">Total Produk</span>
            <span class="font-bold text-xl text-pink-600">
                Rp {{ number_format($total, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- CHECKOUT FORM --}}
    <form action="{{ route('checkout.cart.process') }}" method="POST" class="space-y-8">
        @csrf

        {{-- ADDRESS --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h3>

            <label class="block text-sm font-medium text-gray-700 mb-2" for="address">
                Alamat lengkap
            </label>
            <textarea
                id="address"
                name="address"
                required
                rows="3"
                class="w-full p-3 border rounded-xl bg-white outline-none focus:ring-2 focus:ring-pink-400 @error('address') border-red-300 @enderror"
                placeholder="Masukkan alamat lengkap"
            >{{ old('address') }}</textarea>
            @error('address')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                {{-- CITY --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="city">
                        Kota
                    </label>
                    <input
                        id="city"
                        type="text"
                        name="city"
                        required
                        value="{{ old('city') }}"
                        class="w-full p-3 border rounded-xl bg-white outline-none focus:ring-2 focus:ring-pink-400 @error('city') border-red-300 @enderror"
                        placeholder="Contoh: Semarang"
                    >
                    @error('city')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- POSTAL CODE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="postal_code">
                        Kode Pos
                    </label>
                    <input
                        id="postal_code"
                        type="text"
                        name="postal_code"
                        required
                        value="{{ old('postal_code') }}"
                        class="w-full p-3 border rounded-xl bg-white outline-none focus:ring-2 focus:ring-pink-400 @error('postal_code') border-red-300 @enderror"
                        placeholder="Contoh: 50121"
                    >
                    @error('postal_code')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- SHIPPING TYPE --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Metode Pengiriman</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        *Biaya pengiriman dihitung per toko (Total Transaksi)
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <label class="flex items-center justify-between gap-3 p-4 rounded-2xl border hover:bg-gray-50 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="shipping_type"
                            value="regular"
                            required
                            class="accent-pink-500"
                            {{ old('shipping_type') === 'regular' ? 'checked' : '' }}
                        >
                        <div>
                            <p class="font-medium text-gray-900">Regular</p>
                            <p class="text-sm text-gray-500">Rp 10.000 / toko</p>
                        </div>
                    </div>
                </label>

                <label class="flex items-center justify-between gap-3 p-4 rounded-2xl border hover:bg-gray-50 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <input
                            type="radio"
                            name="shipping_type"
                            value="express"
                            class="accent-pink-500"
                            {{ old('shipping_type') === 'express' ? 'checked' : '' }}
                        >
                        <div>
                            <p class="font-medium text-gray-900">Express</p>
                            <p class="text-sm text-gray-500">Rp 20.000 / toko</p>
                        </div>
                    </div>
                </label>
            </div>

            @error('shipping_type')
                <p class="text-sm text-red-600 mt-3">{{ $message }}</p>
            @enderror
        </div>

        {{-- PAYMENT METHOD --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>

            <div class="space-y-3">
                <label class="flex items-center gap-3 p-4 rounded-2xl border hover:bg-gray-50 cursor-pointer">
                    <input
                        type="radio"
                        name="payment_method"
                        value="wallet"
                        required
                        class="accent-pink-500"
                        {{ old('payment_method') === 'wallet' ? 'checked' : '' }}
                    >
                    <div>
                        <p class="font-medium text-gray-900">Saldo (Wallet)</p>
                        <p class="text-sm text-gray-500">
                            Saldo Anda: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                        </p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 rounded-2xl border hover:bg-gray-50 cursor-pointer">
                    <input
                        type="radio"
                        name="payment_method"
                        value="va"
                        class="accent-pink-500"
                        {{ old('payment_method') === 'va' ? 'checked' : '' }}
                    >
                    <div>
                        <p class="font-medium text-gray-900">Virtual Account (VA)</p>
                        <p class="text-sm text-gray-500">Transfer via bank / VA</p>
                    </div>
                </label>
            </div>

            @error('payment_method')
                <p class="text-sm text-red-600 mt-3">{{ $message }}</p>
            @enderror
        </div>

        {{-- SUBMIT BUTTON --}}
        <button
            type="submit"
            class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-2xl text-lg font-semibold shadow-md transition"
        >
            Bayar Sekarang
        </button>

        <p class="text-xs text-gray-500 text-center">
            Dengan menekan tombol “Bayar Sekarang”, Anda menyetujui detail pesanan & alamat pengiriman.
        </p>

    </form>

</div>
@endsection
