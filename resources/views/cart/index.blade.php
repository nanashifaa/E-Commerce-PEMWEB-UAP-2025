@extends('layouts.public')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-semibold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if ($carts->count() == 0)
        <p class="text-gray-500 text-lg">Keranjang masih kosong.</p>
        <a href="/" class="mt-4 inline-block bg-pink-500 text-white py-3 px-6 rounded-lg">Belanja Sekarang</a>
    @else

        <div class="bg-white rounded-xl shadow p-6 border">

            @foreach ($carts as $cart)
                <div class="flex items-center justify-between border-b pb-5 mb-5">

                    {{-- IMAGE --}}
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . ($cart->product->productImages->first()->image ?? 'default.jpg')) }}"
                             class="w-24 h-24 rounded-xl object-cover">

                        {{-- PRODUCT INFO --}}
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $cart->product->name }}
                            </h2>
                            <p class="text-pink-600 font-bold">
                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- QTY CONTROLLER --}}
                    <div class="flex items-center gap-3">
                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-2">
                                <input type="number" 
                                       name="qty" 
                                       value="{{ $cart->qty }}" 
                                       min="1"
                                       class="w-16 border rounded-lg py-1 px-2 text-center">
                                <button type="submit"
                                        class="px-3 py-1 bg-pink-500 text-white rounded-lg">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- SUBTOTAL --}}
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">
                            Rp {{ number_format($cart->qty * $cart->product->price, 0, ',', '.') }}
                        </p>

                        {{-- HAPUS --}}
                        <form action="{{ route('cart.delete', $cart->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline text-sm">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>

        {{-- TOTAL & CHECKOUT --}}
        <div class="mt-8 bg-white p-6 rounded-xl shadow border">
            <div class="flex justify-between text-xl font-semibold text-gray-900 mb-4">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

    @endif

</div>

@endsection
