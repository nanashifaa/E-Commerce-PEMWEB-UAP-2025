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

{{-- SEARCH RESULT INFO --}}
@if(request('q'))
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-8">
    <div class="bg-white border-2 border-pink-200 rounded-2xl p-4 md:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-3 shadow-sm">
        <div class="flex items-start gap-3">
            <div class="bg-pink-100 rounded-full p-2 mt-0.5">
                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-800 font-medium">
                    Search results for: <span class="font-bold text-pink-600">"{{ request('q') }}"</span>
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    Found {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                    @if(request('category'))
                        <span class="text-pink-600">in {{ $categories->firstWhere('slug', request('category'))->name ?? 'category' }}</span>
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('home') }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm flex items-center gap-2 px-4 py-2 rounded-full hover:bg-pink-50 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Clear Search
        </a>
    </div>
</div>
@endif

{{-- FILTERS --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-10">
    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
        <a href="{{ route('home') }}" class="px-5 py-2 rounded-full border transition whitespace-nowrap {{ !request('category') && !request('q') ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">
            All Products
        </a>
        
        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug] + (request('q') ? ['q' => request('q')] : [])) }}" 
               class="px-5 py-2 rounded-full border transition whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

{{-- PRODUCT GRID --}}
<div id="products" class="max-w-7xl mx-auto px-4 md:px-10 mt-10 mb-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        @if(request('q'))
            Search Results
        @elseif(request('category'))
            {{ $categories->firstWhere('slug', request('category'))->name ?? 'Products' }}
        @else
            Recommendations For You!
        @endif
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
        
        @forelse ($products as $product)
        <div class="group bg-white rounded-2xl p-3 md:p-4 transition hover:shadow-xl border border-transparent hover:border-pink-100 relative">
            
            {{-- Heart Icon --}}
            <button class="absolute top-3 md:top-4 right-3 md:right-4 text-gray-400 hover:text-red-500 z-10 bg-white/80 backdrop-blur-sm rounded-full p-1.5">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>

            {{-- Image --}}
            <div class="w-full aspect-square bg-gray-100 rounded-xl mb-3 md:mb-4 overflow-hidden relative">
                 <a href="{{ route('product.show', $product->slug) }}">
                     @if($product->productImages->first())
                         <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}" 
                              alt="{{ $product->name }}"
                              class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                     @else
                         <div class="w-full h-full flex items-center justify-center text-gray-400">
                             <svg class="w-12 h-12 md:w-16 md:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                             </svg>
                         </div>
                     @endif
                 </a>
            </div>

            {{-- Content --}}
            <div class="mb-2">
                <a href="{{ route('product.show', $product->slug) }}">
                    <h3 class="font-bold text-gray-900 text-sm md:text-lg line-clamp-2 hover:text-pink-600 mb-1">
                        {{ $product->name }}
                    </h3>
                </a>
                <p class="text-[10px] md:text-xs text-gray-500 mb-1">{{ $product->store->name }}</p>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-base md:text-lg text-pink-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
                <p class="text-[10px] md:text-xs text-gray-500 mt-1">Stock: {{ $product->stock }}</p>
            </div>

            {{-- Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                
                <button type="submit" class="w-full py-2 md:py-2.5 rounded-full border border-gray-800 text-gray-800 font-medium text-xs md:text-sm hover:bg-gray-900 hover:text-white transition">
                    Add to Cart
                </button>
            </form>

        </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="flex flex-col items-center">
                    <svg class="w-20 h-20 md:w-24 md:h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">
                        @if(request('q'))
                            No products found
                        @else
                            No products available
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-6 text-sm md:text-base">
                        @if(request('q'))
                            We couldn't find any products matching "<span class="font-semibold text-pink-600">{{ request('q') }}</span>"
                        @else
                            Check back later for new arrivals
                        @endif
                    </p>
                    @if(request('q'))
                        <a href="{{ route('home') }}" class="inline-block bg-pink-600 text-white px-6 py-2.5 rounded-full hover:bg-pink-700 transition-colors text-sm md:text-base font-medium">
                            View All Products
                        </a>
                    @endif
                </div>
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="mt-10">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection