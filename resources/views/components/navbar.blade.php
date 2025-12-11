<nav class="bg-white py-4 px-4 md:px-10 shadow-sm sticky top-0 z-50">
    @php
        $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('qty') : 0;
    @endphp
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
            <form action="{{ route('home') }}" method="GET" class="relative group">
                <input 
                    type="text" 
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search for products, brands and shops" 
                    class="bg-gray-100 group-hover:bg-white border border-transparent group-hover:border-pink-200 outline-none w-full text-sm text-gray-700 px-4 py-3 rounded-full transition-all"
                >
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-pink-600 bg-transparent rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>

        {{-- ACCOUNT & CART --}}
        <div class="flex items-center gap-2">
            @auth
                <div class="relative group">
                    <button class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </button>

                    {{-- DROPDOWN --}}
                     <div class="absolute right-0 top-full pt-2 w-56 hidden group-hover:block group-focus-within:block z-50">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transition-all">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-1">
                                <a href="{{ url('/home') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Home
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Edit Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition-colors group" title="Login">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </a>
            @endauth

            <a href="{{ route('cart.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition-colors group relative" title="Cart">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                {{-- Badge logic if needed later --}}
                @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-[10px] font-semibold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        </div>
    </div>
</nav>
