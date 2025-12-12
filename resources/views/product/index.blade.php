@extends('layouts.public')

@section('content')

<style>
    body, * { font-family: 'Poppins', sans-serif !important; }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    {{-- HEADER --}}
    <div class="bg-[#fce8f4]">
        <div class="max-w-7xl mx-auto px-4 md:px-10 pt-10 pb-6">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                Produk
            </h1>
            <p class="text-gray-600 mt-2 text-sm md:text-base">
                Temukan produk terbaik dari berbagai toko pilihan.
            </p>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-4 md:px-10 pb-16">

        {{-- EMPTY STATE --}}
        @if($products->isEmpty())
            <div class="bg-white rounded-2xl border border-pink-200 shadow-sm p-10 text-center">
                <p class="text-gray-600">Belum ada produk tersedia.</p>
            </div>
        @endif

        {{-- GRID PRODUK --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($products as $product)
                <a href="{{ route('product.show', $product->slug) }}"
                   class="group bg-white rounded-2xl border border-pink-200 shadow-sm
                          hover:shadow-lg hover:-translate-y-1 transition overflow-hidden">

                    {{-- IMAGE --}}
                    <div class="relative aspect-square bg-gray-100 overflow-hidden">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition">

                        {{-- PRICE BADGE --}}
                        <div class="absolute bottom-3 left-3 bg-pink-600 text-white
                                    px-3 py-1 rounded-full text-xs font-semibold shadow">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2">
                            {{ $product->name }}
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $product->store->name ?? 'Official Store' }}
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            {{-- STOCK --}}
                            <span class="text-xs text-gray-500">
                                Stok: {{ $product->stock }}
                            </span>

                            {{-- CTA --}}
                            <span class="text-xs font-semibold text-pink-600 group-hover:underline">
                                Lihat →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

</div>
@endsection