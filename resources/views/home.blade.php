@extends('layouts.public')

@section('content')

{{-- HERO SECTION --}}
<section class="relative w-full h-[380px] rounded-xl overflow-hidden shadow-sm mb-12">

    <img src="https://images.unsplash.com/photo-1521335629791-ce4aec67dd47?q=80&w=1600"
         class="w-full h-full object-cover brightness-[0.75]">

    <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-6">
        <h1 class="text-4xl font-bold tracking-tight drop-shadow-lg">
            Temukan Gaya Terbaikmu ✨
        </h1>
        <p class="text-lg mt-3 opacity-90">
            Koleksi fashion terbaru dari toko terpercaya
        </p>
    </div>

</section>

{{-- KATEGORI FILTER --}}
<div class="px-4 md:px-10 mb-10">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Kategori</h2>

    <div class="flex gap-3 overflow-x-auto pb-2">

        <a href="/"
            class="px-5 py-2 rounded-full border transition 
            {{ request('category') ? 'bg-white text-gray-600' : 'bg-pink-500 text-white border-pink-500' }}">
            Semua
        </a>

        @foreach ($categories as $cat)
            <a href="/?category={{ $cat->slug }}"
                class="px-5 py-2 rounded-full border transition whitespace-nowrap
                {{ request('category') == $cat->slug ? 'bg-pink-500 text-white border-pink-500' : 'bg-white text-gray-600 border-gray-300 hover:border-pink-400 hover:text-pink-600' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

{{-- PRODUK LIST --}}
<div class="px-4 md:px-10 pb-20">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Produk Terbaru</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse ($products as $product)
            <a href="/product/{{ $product->slug }}" 
               class="bg-white rounded-xl border shadow-sm hover:shadow-md transition overflow-hidden">

                {{-- IMAGE --}}
                <div class="w-full h-56 bg-gray-100">
                    <img src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- PRODUCT INFO --}}
                <div class="p-4">
                    <h3 class="font-medium text-gray-900 text-base line-clamp-2">
                        {{ $product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $product->store->name ?? '-' }}
                    </p>

                    <p class="text-pink-600 font-bold mt-2 text-lg">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

            </a>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">Tidak ada produk</p>
        @endforelse

    </div>

</div>

@endsection
