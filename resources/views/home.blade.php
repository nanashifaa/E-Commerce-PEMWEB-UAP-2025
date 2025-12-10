@extends('layouts.public')

@section('content')

{{-- HERO SECTION --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-8">
    <div class="relative bg-pink-50 rounded-3xl overflow-hidden min-h-[500px] flex items-center">
        
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-30 bg-[radial-gradient(#ec4899_1px,transparent_1px)] [background-size:20px_20px]"></div>

        {{-- Content Container --}}
        <div class="container mx-auto flex flex-col-reverse md:flex-row items-center relative z-10 px-6 md:px-12">
            
            {{-- Left Text --}}
            <div class="w-full md:w-1/2 pt-10 md:pt-0 text-center md:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-pink-100 text-pink-600 text-sm font-semibold mb-6 tracking-wide">
                    NEW SEASON ARRIVALS
                </span>
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 leading-tight mb-6">
                    Discover Your <br>
                    <span class="text-pink-600 font-serif italic">True Style</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto md:mx-0">
                    Explore the latest collection of women's fashion, skincare, and beauty essentials. Handpicked just for you.
                </p>
                <div class="flex flex-col md:flex-row gap-4 justify-center md:justify-start">
                    <a href="#products" class="px-8 py-4 bg-pink-600 hover:bg-pink-700 text-white rounded-full font-semibold transition shadow-lg hover:-translate-y-1">
                        Shop Collection
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- FILTERS --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-10">
    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
        <a href="{{ route('home') }}" class="px-5 py-2 rounded-full border transition whitespace-nowrap {{ !request('category') ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">All Products</a>
        
        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug]) }}" 
               class="px-5 py-2 rounded-full border transition whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

{{-- PRODUCT GRID --}}
<div id="products" class="max-w-7xl mx-auto px-4 md:px-10 mt-10 mb-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Recommendations For You!</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        
        @forelse ($products as $product)
        <div class="group bg-white rounded-2xl p-4 transition hover:shadow-xl border border-transparent hover:border-pink-100 relative">
            
            {{-- Heart Icon --}}
            <button class="absolute top-4 right-4 text-gray-400 hover:text-red-500 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </button>

            {{-- Image --}}
            <div class="w-full h-56 bg-gray-100 rounded-xl mb-4 overflow-hidden relative">
                 <a href="{{ route('product.show', $product->slug) }}">
                     <img src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}" 
                          class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                 </a>
            </div>

            {{-- Content --}}
            <div class="flex justify-between items-start mb-2">
                <div>
                    <a href="{{ route('product.show', $product->slug) }}">
                        <h3 class="font-bold text-gray-900 text-lg line-clamp-1 hover:text-pink-600">{{ $product->name }}</h3>
                    </a>
                    <p class="text-xs text-green-600 mt-1">Cheap n Use Selection</p>
                </div>
                <span class="font-bold text-lg text-gray-900">Rp {{ number_format($product->price/1000, 0) }}k</span>
            </div>

            <div class="flex items-center gap-1 mb-4">
                <div class="flex text-yellow-400 text-xs">
                    ★★★★★
                </div>
                <span class="text-xs text-gray-400">(121)</span>
            </div>

            {{-- Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                
                <button class="w-full py-2.5 rounded-full border border-gray-800 text-gray-800 font-medium text-sm hover:bg-gray-900 hover:text-white transition">
                    Add to Cart
                </button>
            </form>

        </div>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                No products found.
            </div>
        @endforelse

    </div>
</div>

@endsection
