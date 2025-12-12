@extends('layouts.public')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-semibold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if ($carts->count() == 0)
        <p class="text-gray-500 text-lg">Keranjang masih kosong.</p>
        <a href="{{ route('home') }}"
           class="mt-4 inline-block bg-pink-500 hover:bg-pink-600 text-white py-3 px-6 rounded-lg">
            Belanja Sekarang
        </a>
    @else

        <div class="bg-white rounded-xl shadow p-6 border">

            @foreach ($carts as $cart)
                @php
                    $stock = (int) ($cart->product->stock ?? 0);
                    $firstImage = $cart->product->productImages->first();
                    $imageUrl = $firstImage
                        ? asset('storage/' . $firstImage->image)
                        : asset('images/no-image.png'); // pastikan file ini ada
                @endphp

                <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-5 mb-5 gap-4">

                    {{-- IMAGE + INFO --}}
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $cart->product->name }}"
                            class="w-24 h-24 rounded-xl object-cover border bg-gray-100"
                        >

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $cart->product->name }}
                            </h2>

                            <p class="text-pink-600 font-bold">
                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Stok: {{ $stock }}
                            </p>
                        </div>
                    </div>

                    {{-- QTY CONTROLLER --}}
                    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="qty" id="qty-{{ $cart->id }}" value="{{ (int)$cart->qty }}">

                        <div class="flex items-center gap-3">
                            {{-- MINUS --}}
                            <button
                                type="button"
                                onclick="updateQty({{ $cart->id }}, -1, {{ $stock }})"
                                class="w-10 h-10 rounded-lg border text-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ (int)$cart->qty <= 1 ? 'disabled' : '' }}
                            >
                                −
                            </button>

                            {{-- DISPLAY QTY --}}
                            <span class="w-12 text-center font-semibold" id="qty-text-{{ $cart->id }}">
                                {{ (int)$cart->qty }}
                            </span>

                            {{-- PLUS --}}
                            <button
                                type="button"
                                onclick="updateQty({{ $cart->id }}, 1, {{ $stock }})"
                                class="w-10 h-10 rounded-lg border text-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ (int)$cart->qty >= $stock ? 'disabled' : '' }}
                            >
                                +
                            </button>
                        </div>
                    </form>

                    {{-- SUBTOTAL + DELETE --}}
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">
                            Rp {{ number_format(((int)$cart->qty) * ((int)$cart->product->price), 0, ',', '.') }}
                        </p>

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

        {{-- TOTAL --}}
        <div class="mt-8 bg-white p-6 rounded-xl shadow border">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('checkout.cart') }}"
               class="block w-full text-center py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-lg font-medium mt-4">
                Lanjut ke Checkout
            </a>
        </div>

    @endif
</div>

<script>
    function updateQty(cartId, change, stock) {
        const input = document.getElementById(`qty-${cartId}`);
        const qtyText = document.getElementById(`qty-text-${cartId}`);

        let qty = parseInt(input.value || "1", 10);
        qty += change;

        if (qty < 1) qty = 1;
        if (qty > stock) qty = stock;

        input.value = qty;
        if (qtyText) qtyText.textContent = qty;

        input.form.submit();
    }
</script>
@endsection
