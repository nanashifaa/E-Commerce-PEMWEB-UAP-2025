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
                <div class="relative group">
                    <button class="flex flex-col items-center gap-1 text-gray-600 hover:text-pink-600">
                        <svg class="w-6 h-6 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-xs font-medium">Account</span>
                    </button>

                    {{-- DROPDOWN --}}
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 hidden group-hover:block transition-all z-50">
                        <div class="p-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ url('/home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-lg mx-1 my-1">
                            Home
                        </a>
                         <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-lg mx-1 my-1">
                            Edit Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg mx-1 my-1">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
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
