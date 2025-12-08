@extends('layouts.public')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-12">

    {{-- BREADCRUMB --}}
    <div class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-pink-600">Home</a> /
        <span class="text-gray-700">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- LEFT: IMAGE GALLERY --}}
        <div>
            <div class="w-full h-[420px] rounded-xl overflow-hidden shadow-md border">
                <img 
                    src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}"
                    class="w-full h-full object-cover">
            </div>

            {{-- Thumbnail List --}}
            <div class="grid grid-cols-4 gap-4 mt-4">
                @foreach ($product->productImages as $img)
                    <img src="{{ asset('storage/'.$img->image) }}"
                         class="w-full h-24 rounded-lg object-cover border cursor-pointer hover:opacity-80 transition">
                @endforeach
            </div>
        </div>

        {{-- RIGHT: PRODUCT INFO --}}
        <div>

            <h1 class="text-3xl font-bold text-gray-900 leading-tight">
                {{ $product->name }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kategori: <span class="text-gray-700">{{ $product->productCategory->name ?? '-' }}</span>
            </p>

            <p class="text-sm text-gray-500">
                Toko: <span class="text-pink-600 font-semibold">{{ $product->store->name ?? '-' }}</span>
            </p>

            {{-- PRICE --}}
            <p class="text-4xl font-bold text-pink-600 mt-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            {{-- DESCRIPTION --}}
            <p class="mt-6 text-gray-700 leading-relaxed">
                {{ $product->description }}
            </p>

           {{-- BUY & CART BUTTONS --}}
<div class="mt-8 flex flex-col gap-4">

    {{-- Tombol Tambah ke Keranjang --}}
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit"
                class="w-full py-3 bg-pink-400 hover:bg-pink-500 text-white rounded-lg font-medium text-lg transition">
            Tambah ke Keranjang
        </button>
    </form>

    {{-- Tombol Beli Sekarang --}}
    <a href="/checkout/{{ $product->slug }}"
       class="w-full text-center py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-lg font-medium text-lg transition">
        Beli Sekarang
    </a>

</div>

        </div>
    </div>

    {{-- REVIEWS --}}
    <div class="mt-16">

        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Ulasan Pembeli</h2>

        @forelse ($product->productReviews as $review)
            <div class="bg-white border rounded-xl p-5 shadow-sm mb-4">
                <div class="flex justify-between">
                    <h3 class="font-medium text-gray-800">{{ $review->user->name ?? 'Unknown User' }}</h3>
                    <span class="text-yellow-500 font-semibold">⭐ {{ $review->rating }}/5</span>
                </div>

                <p class="mt-2 text-gray-700">{{ $review->review }}</p>
            </div>

        @empty
            <p class="text-gray-500">Belum ada ulasan.</p>
        @endforelse

    </div>

</div>

@endsection
