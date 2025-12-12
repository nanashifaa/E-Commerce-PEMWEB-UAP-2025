@extends('layouts.public')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- BREADCRUMB --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="/" class="hover:text-pink-600">Home</a>
        <span>/</span>
        <span class="text-gray-700 line-clamp-1">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- LEFT: IMAGE GALLERY --}}
        @php
            $firstImage = $product->productImages->first()->image ?? null;
            $mainImage = $firstImage ? asset('storage/'.$firstImage) : asset('images/default.jpg');
        @endphp

        <div>
            {{-- Main Image --}}
            <div class="w-full h-[420px] rounded-2xl overflow-hidden shadow-sm border bg-gray-50">
                <img id="mainImage"
                     src="{{ $mainImage }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- Thumbnails --}}
            @if($product->productImages->count())
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach ($product->productImages as $img)
                        @php $thumb = asset('storage/'.$img->image); @endphp
                        <button type="button"
                                class="group relative w-full h-24 rounded-xl overflow-hidden border bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-400"
                                onclick="document.getElementById('mainImage').src='{{ $thumb }}'">
                            <img src="{{ $thumb }}"
                                 alt="Thumbnail {{ $loop->iteration }}"
                                 class="w-full h-full object-cover group-hover:scale-[1.02] transition">
                        </button>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500">Tidak ada gambar tambahan.</p>
            @endif
        </div>

        {{-- RIGHT: PRODUCT INFO --}}
        <div class="md:pt-2">
            <div class="flex flex-col gap-3">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                        Kategori: <span class="font-medium">{{ $product->productCategory->name ?? '-' }}</span>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-700">
                        Toko: <span class="font-semibold">{{ $product->store->name ?? '-' }}</span>
                    </span>
                </div>

                {{-- Rating Summary --}}
                @php
                    $avgRating = round($product->productReviews->avg('rating') ?? 0, 1);
                    $reviewCount = $product->productReviews->count();
                @endphp
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="text-yellow-500 font-semibold">⭐ {{ $avgRating }}/5</span>
                    <span class="text-gray-400">•</span>
                    <span>{{ $reviewCount }} ulasan</span>
                </div>

                {{-- PRICE --}}
                <div class="mt-4">
                    <p class="text-4xl font-extrabold text-pink-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Harga belum termasuk ongkir (jika ada).</p>
                </div>

                {{-- DESCRIPTION --}}
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                    <p class="mt-2 text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </p>
                </div>

                {{-- ACTIONS --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    {{-- Tambah ke Keranjang --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                                class="w-full py-3 rounded-xl font-semibold text-lg
                                       bg-pink-100 text-pink-700 hover:bg-pink-200 transition
                                       border border-pink-200">
                            + Keranjang
                        </button>
                    </form>

                    {{-- Beli Sekarang --}}
                    <a href="{{ route('checkout.index', $product->slug) }}"
                       class="w-full py-3 rounded-xl font-semibold text-lg text-center
                              bg-pink-500 text-white hover:bg-pink-600 transition">
                        Beli Sekarang
                    </a>
                </div>

                {{-- Small note --}}
                <p class="text-xs text-gray-500 mt-2">
                    Pastikan stok & variasi (jika ada) sesuai sebelum checkout.
                </p>
            </div>
        </div>

    </div>

    {{-- REVIEWS --}}
    <div class="mt-14">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Ulasan Pembeli</h2>
            <span class="text-sm text-gray-500">{{ $reviewCount }} ulasan</span>
        </div>

        @forelse ($product->productReviews as $review)
            <div class="bg-white border rounded-2xl p-5 shadow-sm mb-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-800">
                            {{ $review->user->name ?? 'Unknown User' }}
                        </h3>
                        <p class="text-xs text-gray-400">
                            {{ optional($review->created_at)->format('d M Y') }}
                        </p>
                    </div>
                    <span class="text-yellow-500 font-semibold whitespace-nowrap">
                        ⭐ {{ $review->rating }}/5
                    </span>
                </div>

                <p class="mt-3 text-gray-700 whitespace-pre-line">{{ $review->review }}</p>
            </div>
        @empty
            <div class="border rounded-2xl p-6 bg-gray-50 text-gray-600">
                Belum ada ulasan.
            </div>
        @endforelse
    </div>

</div>
@endsection
