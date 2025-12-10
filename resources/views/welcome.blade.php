<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Cheap n Use') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

<body class="bg-gray-50">

    {{-- NAVBAR --}}
    <nav class="bg-white py-4 px-4 md:px-10 shadow-sm sticky top-0 z-50">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            
            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xl">C</div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-800 tracking-tight leading-none">Cheap n Use</span>
                    <span class="text-[10px] text-gray-500 tracking-widest uppercase">Fashion & Beauty</span>
                </div>
            </a>

            {{-- SEARCH --}}
            <div class="flex-1 max-w-2xl relative w-full">
                <div class="relative group">
                    <input type="text" placeholder="Search for products, brands and shops" class="bg-gray-100 group-hover:bg-white border border-transparent group-hover:border-pink-200 outline-none w-full text-sm text-gray-700 px-4 py-3 rounded-full transition-all">
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-pink-600 bg-transparent rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </div>

            {{-- ACCOUNT & CART --}}
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ url('/home') }}" class="flex flex-col items-center gap-1 text-gray-600 hover:text-pink-600 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-xs font-medium">Account</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 text-gray-600 hover:text-pink-600 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        <span class="text-xs font-medium">Login</span>
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-1 text-gray-600 hover:text-pink-600 group">
                    <div class="relative">
                        <svg class="w-6 h-6 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        {{-- <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full border-2 border-white">0</span> --}}
                    </div>
                    <span class="text-xs font-medium">Cart</span>
                </a>
            </div>
        </div>
    </nav>

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

                {{-- Right Image (Model) --}}

            </div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="max-w-7xl mx-auto px-4 md:px-10 mt-10">
        <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Fashion Type ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Price ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Review ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Color ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Material ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">Offer ▾</button>
            <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-pink-100 hover:text-pink-700 text-sm font-medium transition whitespace-nowrap">All Filters 📑</button>
            
            <div class="ml-auto">
                <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-sm font-medium flex items-center gap-2">
                    Sort by ▾
                </button>
            </div>
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
                     <img src="{{ asset('storage/' . ($product->productImages->first()->image ?? 'default.jpg')) }}" 
                          class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                {{-- Content --}}
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg line-clamp-1">{{ $product->name }}</h3>
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

</body>
</html>
