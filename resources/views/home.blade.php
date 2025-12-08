@extends('layouts.public')

@section('content')

<div class="px-4 md:px-10 py-10">

    {{-- TITLE SECTION --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-semibold text-pink-600">
            Cheap & Use.
        </h1>

        <p class="text-gray-700 mt-2 text-lg">
            Trendy • Affordable • Pretty 𝜗ৎ
        </p>
    </div>

    {{-- CATEGORY FILTER --}}
    <div class="mb-12">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kategori</h2>

        <div class="flex gap-3 overflow-x-auto pb-3">

            <a href="/"
               class="px-5 py-2 rounded-full transition font-medium border 
               {{ request('category') ? 'bg-white text-gray-600 border-gray-300' : 'bg-pink-500 text-white border-pink-500 shadow-md' }}">
               Semua
            </a>

            @foreach ($categories as $cat)
                <a href="/?category={{ $cat->slug }}"
                   class="px-5 py-2 rounded-full transition font-medium whitespace-nowrap border
                   {{ request('category') == $cat->slug 
                      ? 'bg-pink-500 text-white border-pink-500 shadow-md'
                      : 'bg-white text-gray-600 border-gray-200 hover:border-pink-400 hover:text-pink-600' }}">
                   {{ $cat->name }}
                </a>
            @endforeach

        </div>
    </div>

    {{-- PRODUCT LIST --}}
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Produk Terbaru</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        @forelse ($products as $product)
            <a href="{{ route('product.show', $product->slug) }}"
               class="bg-white rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">

                {{-- IMAGE --}}
                <div class="w-full h-64 rounded-t-2xl overflow-hidden bg-pink-100">
                    <img src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- INFO --}}
                <div class="p-4">
                    <h3 class="font-medium text-gray-900 text-base line-clamp-2 leading-snug">
                        {{ $product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $product->store->name ?? '-' }}
                    </p>

                    <p class="text-pink-600 font-bold mt-3 text-lg">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

            </a>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">Belum ada produk</p>
        @endforelse

    </div>

</div>

@endsection
