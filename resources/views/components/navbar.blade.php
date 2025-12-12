<nav class="bg-white shadow-sm border-b sticky top-0 z-50">
    @php
        $user = auth()->user();

        $isHome     = request()->routeIs('home') || request()->is('home') || request()->is('/');
        $isProducts = request()->routeIs('products.index') || request()->routeIs('product.search') || request()->is('products*') || request()->is('search*');
        $isHistory  = request()->routeIs('history.*') || request()->is('history*');
        $isWallet   = request()->routeIs('wallet.*') || request()->is('wallet/topup*');
    @endphp

    <div class="max-w-7xl mx-auto px-4 md:px-10">
        <div class="flex items-center justify-between py-4 gap-4">

            {{-- KIRI: LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-pink-600 text-white flex items-center justify-center font-bold text-xl">
                    C
                </div>
                <div class="leading-tight">
                    <div class="text-lg md:text-xl font-bold text-gray-900">Cheap n Use</div>
                    <div class="hidden md:block text-[10px] text-gray-400 uppercase tracking-[0.25em]">Fashion & Beauty</div>
                </div>
            </a>

            {{-- MENU DESKTOP --}}
            <div class="hidden lg:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}"
                   class="{{ $isHome ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Beranda
                </a>

                {{-- ✅ PRODUK: pindah ke /products --}}
                <a href="{{ route('products.index') }}"
                   class="{{ $isProducts ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Produk
                </a>

                @if(auth()->check() && auth()->user()->role === 'member')
                    <a href="{{ route('history.index') }}"
                       class="{{ $isHistory ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                        Riwayat
                    </a>

                    <a href="{{ route('wallet.topup') }}"
                       class="{{ $isWallet ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                        Dompet
                    </a>
                @endif
            </div>

            {{-- SEARCH (DESKTOP) --}}
            <div class="hidden md:flex flex-1 justify-center px-4">
                {{-- ✅ Search harus ke route search --}}
                <form action="{{ route('product.search') }}" method="GET" class="w-full max-w-lg">
                    <div class="flex items-center gap-3 bg-gray-100 rounded-full px-4 py-2 border border-gray-200
                                focus-within:border-pink-400 focus-within:ring-1 focus-within:ring-pink-400 transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>

                        <input type="text" name="q" value="{{ request('q') }}"
                               class="flex-1 bg-transparent border-none text-sm placeholder-gray-400 focus:ring-0"
                               placeholder="Cari produk...">

                        <button class="px-4 py-1.5 bg-pink-600 text-white rounded-full text-xs font-semibold hover:bg-pink-700 transition">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- KANAN: ICONS --}}
            <div class="flex items-center gap-2">

                {{-- SEARCH ICON MOBILE --}}
                <button id="mobile-search-btn"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white
                               text-gray-700 hover:bg-gray-50 transition"
                        aria-label="Cari">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                {{-- CART --}}
                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white
                          text-gray-700 hover:bg-gray-50 transition"
                   aria-label="Keranjang">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l1.5-7H6.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M9 22a1 1 0 100-2 1 1 0 000 2zM17 20a1 1 0 100-2 1 1 0 000 2z"/>
                    </svg>

                    @php $cartCount = session('cart_count') ?? 0; @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-[10px] flex items-center justify-center rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- HAMBURGER MOBILE --}}
                <button id="mobile-menu-btn"
                        class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white
                               text-gray-700 hover:bg-gray-50 transition"
                        aria-label="Buka menu">
                    <svg id="icon-burger" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- PROFIL (DESKTOP) --}}
                @auth
                    <div class="relative hidden lg:block">
                        <button id="profil-btn" class="flex items-center gap-3 px-3 py-2 rounded-full hover:bg-gray-50 transition">
                            <div class="w-9 h-9 rounded-full bg-pink-600 text-white flex items-center justify-center font-bold uppercase">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="flex flex-col items-start leading-tight">
                                <span class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                                <span class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</span>
                            </div>

                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="profil-menu"
                             class="hidden absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                Profil Saya
                            </a>

                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button" id="logout-btn"
                                        class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        {{-- SEARCH BAR MOBILE --}}
        <div id="mobile-search-bar" class="md:hidden hidden pb-4">
            <form action="{{ route('product.search') }}" method="GET" class="w-full">
                <div class="flex items-center gap-2 bg-gray-100 rounded-full px-3 py-2 border border-gray-200
                            focus-within:border-pink-400 focus-within:ring-1 focus-within:ring-pink-400 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 0 0114 0z"/>
                    </svg>

                    <input type="text" name="q" value="{{ request('q') }}"
                           class="flex-1 bg-transparent border-none text-sm placeholder-gray-400 focus:ring-0"
                           placeholder="Cari produk...">

                    <button class="px-3 py-1 bg-pink-600 text-white rounded-full text-xs font-semibold hover:bg-pink-700 transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- MENU MOBILE --}}
        <div id="mobile-menu" class="lg:hidden hidden pb-4">
            <div class="mt-2 rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">

                <a href="{{ route('home') }}"
                   class="block px-5 py-3 text-sm font-medium {{ $isHome ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Beranda
                </a>

                {{-- ✅ PRODUK MOBILE: pindah ke /products --}}
                <a href="{{ route('products.index') }}"
                   class="block px-5 py-3 text-sm font-medium {{ $isProducts ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Produk
                </a>

                @if(auth()->check() && auth()->user()->role === 'member')
                    <a href="{{ route('history.index') }}"
                       class="block px-5 py-3 text-sm font-medium {{ $isHistory ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                        Riwayat Transaksi
                    </a>

                    <a href="{{ route('wallet.topup') }}"
                       class="block px-5 py-3 text-sm font-medium {{ $isWallet ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                        Dompet / Top Up
                    </a>
                @endif

                <div class="border-t border-gray-100">
                    @auth
                        <a href="{{ route('profile.edit') }}"
                           class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Profil Saya
                        </a>

                        <button type="button" id="logout-btn-mobile"
                                class="w-full text-left px-5 py-3 text-sm font-medium text-red-600 hover:bg-red-50">
                            Keluar
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                           class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // MOBILE MENU
    const mobileBtn   = document.getElementById('mobile-menu-btn');
    const mobileMenu  = document.getElementById('mobile-menu');
    const iconBurger  = document.getElementById('icon-burger');
    const iconClose   = document.getElementById('icon-close');

    function toggleMobileMenu(forceClose = false) {
        if (!mobileMenu) return;
        const isHidden = mobileMenu.classList.contains('hidden');

        if (forceClose) {
            mobileMenu.classList.add('hidden');
            iconBurger?.classList.remove('hidden');
            iconClose?.classList.add('hidden');
            return;
        }

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            iconBurger?.classList.add('hidden');
            iconClose?.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
            iconBurger?.classList.remove('hidden');
            iconClose?.classList.add('hidden');
        }
    }

    mobileBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        toggleMobileMenu();
    });

    // MOBILE SEARCH
    const mobileSearchBtn = document.getElementById('mobile-search-btn');
    const mobileSearchBar = document.getElementById('mobile-search-bar');
    mobileSearchBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        mobileSearchBar?.classList.toggle('hidden');
    });

    // PROFILE DROPDOWN (DESKTOP)
    const profilBtn  = document.getElementById('profil-btn');
    const profilMenu = document.getElementById('profil-menu');

    profilBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        profilMenu?.classList.toggle('hidden');
    });

    // LOGOUT CONFIRM
    const logoutBtn       = document.getElementById('logout-btn');
    const logoutBtnMobile = document.getElementById('logout-btn-mobile');
    const logoutForm      = document.getElementById('logout-form');

    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari akun?',
            text: 'Anda akan logout dari akun ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) logoutForm?.submit();
        });
    }

    logoutBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        confirmLogout();
    });

    logoutBtnMobile?.addEventListener('click', (e) => {
        e.preventDefault();
        confirmLogout();
    });

    // CLICK OUTSIDE CLOSE
    document.addEventListener('click', (e) => {
        if (profilBtn && profilMenu && !profilBtn.contains(e.target) && !profilMenu.contains(e.target)) {
            profilMenu.classList.add('hidden');
        }
        const nav = document.querySelector('nav');
        if (nav && mobileMenu && !nav.contains(e.target)) {
            toggleMobileMenu(true);
        }
    });
</script>
