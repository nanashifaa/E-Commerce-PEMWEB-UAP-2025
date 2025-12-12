@extends('layouts.public')

@section('content')

{{-- HERO SECTION --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-6">
    <div class="relative bg-gradient-to-r from-pink-50 via-rose-50 to-white rounded-3xl overflow-hidden min-h-[480px] flex items-center border border-pink-100 shadow-[0_20px_60px_rgba(236,72,153,0.12)]">
        
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-40 bg-[radial-gradient(#fecaca_1px,transparent_1px)] [background-size:22px_22px]"></div>
        <div class="absolute -right-24 -top-24 w-72 h-72 bg-pink-200/40 rounded-full blur-3xl"></div>
        <div class="absolute -left-24 -bottom-24 w-72 h-72 bg-rose-200/40 rounded-full blur-3xl"></div>

        {{-- Content Container --}}
        <div class="relative z-10 flex flex-col md:flex-row items-center w-full gap-10 px-6 md:px-12 py-10">
            
            {{-- Left Text --}}
            <div class="w-full md:w-7/12">
                <div class="inline-flex items-center gap-2 py-1 px-3 rounded-full bg-white/80 border border-pink-100 text-pink-600 text-xs font-semibold mb-5 tracking-wide shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></span>
                    NEW SEASON ARRIVALS
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 leading-tight mb-4">
                    Discover Your
                    <span class="block text-pink-600 font-serif italic mt-1">
                        True Style
                    </span>
                </h1>

                <p class="text-base md:text-lg text-gray-600 mb-6 max-w-xl">
                    Explore curated fashion, skincare, and beauty essentials. Handpicked pieces to make everyday feel like a special occasion.
                </p>

                {{-- CTA BUTTONS: bedakan guest vs member --}}
                @guest
                    <div class="flex flex-col sm:flex-row gap-3 mb-5">
                        <a href="#products" 
                           class="px-8 py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-full font-semibold transition shadow-lg hover:-translate-y-1 text-center">
                            Lihat Produk
                        </a>
                        <a href="{{ route('login') }}"
                           class="px-8 py-3 bg-white hover:bg-pink-50 text-pink-600 rounded-full font-semibold transition border border-pink-200 text-center">
                            Login / Register
                        </a>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-3 mb-5">
                        <a href="#products" 
                           class="px-8 py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-full font-semibold transition shadow-lg hover:-translate-y-1 text-center">
                            Shop Collection
                        </a>
                        <a href="#shop-by-category"
                           class="px-8 py-3 bg-white hover:bg-pink-50 text-pink-600 rounded-full font-semibold transition border border-pink-200 text-center">
                            Browse Categories
                        </a>
                    </div>
                @endguest

                {{-- Small benefits line --}}
                <div class="flex flex-wrap items-center gap-3 text-xs md:text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-xs">✓</span>
                        100% Authentic Products
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-xs">🚚</span>
                        Fast & Secure Shipping
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-xs">💬</span>
                        24/7 Support
                    </div>
                </div>
            </div>

            {{-- Right Side Promo / Highlight --}}
            <div class="w-full md:w-5/12 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <div class="aspect-[3/4] rounded-3xl bg-gradient-to-b from-white to-pink-100 border border-pink-100 shadow-xl overflow-hidden flex items-end p-4">
                        <div class="absolute inset-x-4 top-4 flex justify-between">
                            <span class="px-3 py-1 rounded-full bg-white/80 text-xs font-semibold text-pink-600 border border-pink-100">
                                Limited Offer
                            </span>
                            <span class="px-3 py-1 rounded-full bg-pink-600/90 text-xs font-semibold text-white shadow">
                                Up to 40% OFF
                            </span>
                        </div>
                        <div class="w-full">
                            <div class="bg-white/90 rounded-2xl p-4 shadow-lg">
                                <p class="text-[11px] text-gray-500 mb-1 uppercase tracking-[0.15em] font-semibold">
                                    Featured Collection
                                </p>
                                <p class="text-sm font-semibold text-gray-900 mb-1">
                                    Glow Essentials Skincare Set
                                </p>
                                <p class="text-xs text-gray-500 mb-3">
                                    Hydrating, brightening, and gentle on all skin types.
                                </p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500 line-through">Rp 450.000</p>
                                        <p class="text-lg font-bold text-pink-600">Rp 299.000</p>
                                    </div>
                                    <a href="#products" class="inline-flex items-center gap-1 text-xs font-semibold text-pink-600 hover:text-pink-700">
                                        Shop now
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QUICK STATS --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white border border-pink-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center">
                <span class="text-pink-600 text-lg">🛍️</span>
            </div>
            <div>
                <p class="text-[11px] text-gray-500 uppercase tracking-[0.15em]">Products</p>
                <p class="text-sm font-semibold text-gray-800">{{ number_format($products->total()) }} items</p>
            </div>
        </div>
        <div class="bg-white border border-pink-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center">
                <span class="text-pink-600 text-lg">🏷️</span>
            </div>
            <div>
                <p class="text-[11px] text-gray-500 uppercase tracking-[0.15em]">Categories</p>
                <p class="text-sm font-semibold text-gray-800">{{ $categories->count() }} types</p>
            </div>
        </div>
        <div class="bg-white border border-pink-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center">
                <span class="text-pink-600 text-lg">✨</span>
            </div>
            <div>
                <p class="text-[11px] text-gray-500 uppercase tracking-[0.15em]">Curated For You</p>
                <p class="text-sm font-semibold text-gray-800">Daily updated</p>
            </div>
        </div>
        <div class="bg-white border border-pink-100 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-sm">
            <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center">
                <span class="text-pink-600 text-lg">⭐</span>
            </div>
            <div>
                <p class="text-[11px] text-gray-500 uppercase tracking-[0.15em]">Quality</p>
                <p class="text-sm font-semibold text-gray-800">Trusted sellers</p>
            </div>
        </div>
    </div>
</div>

{{-- SHOP BY CATEGORY --}}
<div id="shop-by-category" class="max-w-7xl mx-auto px-4 md:px-10 mt-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Shop by Category</h2>
        <span class="text-xs md:text-sm text-gray-500">Find what suits you best</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
        {{-- Card 1 --}}
        <a href="{{ route('home', ['category' => 'fashion']) }}"
           class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 text-white p-5 md:p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_left,_#fff_0,_transparent_60%)]"></div>
            <div class="relative z-10">
                <p class="text-[11px] uppercase tracking-[0.2em] mb-1">Hot Picks</p>
                <h3 class="text-lg md:text-xl font-semibold mb-1">Fashion & Apparel</h3>
                <p class="text-xs md:text-sm text-pink-50 mb-3">Trendy outfits, everyday wear, and more.</p>
                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-white/10 px-3 py-1 rounded-full">
                    Explore now
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 2 --}}
        <a href="{{ route('home', ['category' => 'beauty']) }}"
           class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 text-white p-5 md:p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition">
            <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_bottom_right,_#fff_0,_transparent_60%)]"></div>
            <div class="relative z-10">
                <p class="text-[11px] uppercase tracking-[0.2em] mb-1">Best Seller</p>
                <h3 class="text-lg md:text-xl font-semibold mb-1">Makeup & Beauty</h3>
                <p class="text-xs md:text-sm text-pink-50 mb-3">Lips, eyes, and face essentials.</p>
                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-white/10 px-3 py-1 rounded-full">
                    Discover looks
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 3 --}}
        <a href="{{ route('home', ['category' => 'skincare']) }}"
           class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white p-5 md:p-6 shadow-lg hover:shadow-xl hover:-translate-y-1 transition">
            <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_top_right,_#fff_0,_transparent_60%)]"></div>
            <div class="relative z-10">
                <p class="text-[11px] uppercase tracking-[0.2em] mb-1">Self Care</p>
                <h3 class="text-lg md:text-xl font-semibold mb-1">Skincare & Body</h3>
                <p class="text-xs md:text-sm text-emerald-50 mb-3">Glow-up routine, from AM to PM.</p>
                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-white/10 px-3 py-1 rounded-full">
                    Build routine
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </div>
        </a>
    </div>
</div>

{{-- SEARCH RESULT INFO --}}
@if(request('q'))
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-8">
    <div class="bg-white border-2 border-pink-200 rounded-2xl p-4 md:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-3 shadow-sm">
        <div class="flex items-start gap-3">
            <div class="bg-pink-100 rounded-full p-2 mt-0.5">
                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-800 font-medium">
                    Search results for: <span class="font-bold text-pink-600">"{{ request('q') }}"</span>
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    Found {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                    @if(request('category'))
                        <span class="text-pink-600">
                            in {{ $categories->firstWhere('slug', request('category'))->name ?? 'category' }}
                        </span>
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('home') }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm flex items-center gap-2 px-4 py-2 rounded-full hover:bg-pink-50 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Clear Search
        </a>
    </div>
</div>
@endif

{{-- FILTERS + SORT --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mt-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        {{-- Categories Pills --}}
        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('home') }}"
               class="px-5 py-2 rounded-full border text-xs md:text-sm transition whitespace-nowrap
               {{ !request('category') && !request('q') ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">
                All Products
            </a>
            
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug] + (request('q') ? ['q' => request('q')] : [])) }}"
                   class="px-5 py-2 rounded-full border text-xs md:text-sm transition whitespace-nowrap
                   {{ request('category') == $cat->slug ? 'bg-pink-600 text-white border-pink-600' : 'bg-gray-100 text-gray-600 border-transparent hover:bg-pink-50' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Sort Dropdown --}}
        <form action="{{ route('home') }}" method="GET" class="flex items-center gap-2 justify-end">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <label for="sort" class="text-xs md:text-sm text-gray-500">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()"
                    class="text-xs md:text-sm border-gray-200 rounded-full px-3 py-1.5 bg-white focus:ring-pink-500 focus:border-pink-500">
                <option value="">Default</option>
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </form>
    </div>
</div>

{{-- PRODUCT GRID --}}
<div id="products" class="max-w-7xl mx-auto px-4 md:px-10 mt-8 mb-20">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        @if(request('q'))
            Search Results
        @elseif(request('category'))
            {{ $categories->firstWhere('slug', request('category'))->name ?? 'Products' }}
        @else
            Recommendations For You!
        @endif
    </h2>
    <p class="text-sm text-gray-500 mb-6">
        Showing <span class="font-semibold text-pink-600">{{ $products->count() }}</span> of
        <span class="font-semibold">{{ $products->total() }}</span> products
    </p>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
        
        @forelse ($products as $product)
            @php
                $isNew = $product->created_at && $product->created_at->gt(now()->subDays(7));
                $isLowStock = $product->stock <= 3;
            @endphp

            <div class="group bg-white rounded-2xl p-3 md:p-4 transition hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)] border border-gray-100 hover:border-pink-200 relative">
                
                {{-- Badge New / Low Stock --}}
                <div class="absolute top-3 left-3 flex flex-col gap-1 z-10">
                    @if($isNew)
                        <span class="text-[10px] px-2 py-1 rounded-full bg-pink-600 text-white font-semibold shadow">
                            New
                        </span>
                    @endif
                    @if($isLowStock)
                        <span class="text-[10px] px-2 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold border border-amber-200">
                            Low stock
                        </span>
                    @endif
                </div>

                {{-- Heart Icon --}}
                <button class="absolute top-3 right-3 text-gray-400 hover:text-red-500 z-10 bg-white/80 backdrop-blur-sm rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>

                {{-- Image --}}
                <div class="w-full aspect-square bg-gray-50 rounded-xl mb-3 md:mb-4 overflow-hidden relative">
                    <a href="{{ route('product.show', $product->slug) }}">
                        @if($product->productImages->first())
                            <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-12 h-12 md:w-16 md:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </a>

                    {{-- Quick info pill --}}
                    <div class="absolute bottom-2 left-2 bg-black/60 text-white text-[10px] px-2 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Ready stock
                    </div>
                </div>

                {{-- Content --}}
                <div class="mb-2">
                    <a href="{{ route('product.show', $product->slug) }}">
                        <h3 class="font-semibold text-gray-900 text-sm md:text-base line-clamp-2 hover:text-pink-600 mb-1">
                            {{ $product->name }}
                        </h3>
                    </a>
                    <p class="text-[11px] md:text-xs text-gray-500 mb-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span>
                        {{ $product->store->name }}
                    </p>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="font-bold text-base md:text-lg text-pink-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] md:text-xs text-gray-500">
                            Stock: <span class="font-medium {{ $isLowStock ? 'text-amber-600' : '' }}">{{ $product->stock }}</span>
                        </p>
                        <p class="text-[11px] md:text-xs text-gray-500 flex items-center gap-1">
                            <span class="text-yellow-400">★</span> 4.8
                        </p>
                    </div>
                </div>

                {{-- ACTION AREA: beda guest / member / role lain --}}
                <div class="mt-3">
                    @auth
                        @if(auth()->user()->role === 'member')
                            {{-- MEMBER: bisa Add to Cart --}}
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                
                                <button type="submit"
                                        class="w-full py-2 md:py-2.5 rounded-full border border-gray-900 text-gray-900 font-medium text-xs md:text-sm hover:bg-gray-900 hover:text-white transition flex items-center justify-center gap-1">
                                    <span class="text-sm">🛒</span>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            {{-- SELLER / ADMIN: tidak bisa beli --}}
                            <button type="button"
                                    class="w-full py-2 md:py-2.5 rounded-full border border-gray-300 text-gray-400 font-medium text-xs md:text-sm bg-gray-50 cursor-not-allowed flex items-center justify-center gap-1">
                                Hanya member yang bisa membeli
                            </button>
                        @endif
                    @else
                        {{-- GUEST: ajak login / register --}}
                        <a href="{{ route('login') }}"
                           class="w-full inline-flex items-center justify-center gap-1 py-2 md:py-2.5 rounded-full border border-pink-600 text-pink-600 font-medium text-xs md:text-sm hover:bg-pink-600 hover:text-white transition">
                            <span class="text-sm">🔒</span>
                            Login untuk membeli
                        </a>
                    @endauth
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="flex flex-col items-center">
                    <svg class="w-20 h-20 md:w-24 md:h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                            We couldn't find any products matching 
                            "<span class="font-semibold text-pink-600">{{ request('q') }}</span>"
                        @else
                            Check back later for new arrivals
                        @endif
                    </p>
                    @if(request('q'))
                        <a href="{{ route('home') }}"
                           class="inline-block bg-pink-600 text-white px-6 py-2.5 rounded-full hover:bg-pink-700 transition-colors text-sm md:text-base font-medium">
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

{{-- SMALL PROMO SECTION --}}
<div class="max-w-7xl mx-auto px-4 md:px-10 mb-16">
    <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white px-6 md:px-10 py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <p class="text-xs uppercase tracking-[0.25em] text-pink-300 mb-2">Stay in the loop</p>
            <h3 class="text-xl md:text-2xl font-semibold mb-2">
                Get early access to drops & exclusive deals
            </h3>
            <p class="text-sm md:text-base text-slate-300 max-w-md">
                Subscribe to our newsletter and be the first to know about new arrivals, curated collections, and members-only promotions.
            </p>
        </div>
        <form class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
            <input type="email" class="px-4 py-2.5 rounded-full bg-slate-800 border border-slate-600 text-sm focus:ring-2 focus:ring-pink-500 focus:border-pink-500 w-full sm:w-64"
                   placeholder="Enter your email">
            <button type="button"
                    class="px-5 py-2.5 rounded-full bg-pink-500 hover:bg-pink-600 text-sm font-semibold shadow-lg shadow-pink-500/30">
                Notify me
            </button>
        </form>
    </div>
</div>

@push('scripts')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#ec4899'
                });
            });
        </script>
    @endif
@endpush

@endsection
