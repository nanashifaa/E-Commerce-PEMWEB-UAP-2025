<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 md:px-10">
        <div class="flex items-center justify-between py-4 gap-4">

            {{-- KIRI: LOGO --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-pink-600 text-white flex items-center justify-center font-bold text-xl">
                    S
                </div>
                <span class="text-lg md:text-xl font-bold text-gray-900">
                    Panel Seller
                </span>
            </div>

            {{-- TENGAH: MENU DESKTOP --}}
            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ url('/seller/dashboard') }}"
                   class="{{ request()->is('seller/dashboard') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Beranda
                </a>

                <a href="{{ url('/seller/orders') }}"
                   class="{{ request()->is('seller/orders*') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Pesanan
                </a>

                <a href="{{ url('/seller/products') }}"
                   class="{{ request()->is('seller/products*') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Produk
                </a>

                <a href="{{ url('/seller/categories') }}"
                   class="{{ request()->is('seller/categories*') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Kategori
                </a>

                <a href="{{ url('/seller/balance') }}"
                   class="{{ request()->is('seller/balance') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Saldo
                </a>

                <a href="{{ url('/seller/withdrawals') }}"
                   class="{{ request()->is('seller/withdrawals*') ? 'text-pink-600 border-b-2 border-pink-600 pb-1' : 'text-gray-600 hover:text-pink-600' }}">
                    Penarikan
                </a>
            </div>

            {{-- KANAN: HAMBURGER (MOBILE) + PROFIL --}}
            <div class="flex items-center gap-2">

                {{-- HAMBURGER MOBILE --}}
                <button id="mobile-menu-btn"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white
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

                {{-- PROFIL DROPDOWN --}}
                <div class="relative">
                    <button id="profil-btn" class="flex items-center gap-3 focus:outline-none">
                        <div class="w-9 h-9 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>

                        <div class="hidden md:flex flex-col items-start">
                            <span class="text-sm font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-xs text-gray-500">
                                Seller
                            </span>
                        </div>

                        <svg class="hidden md:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="profil-menu"
                         class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Akun Seller</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                            Profil Saya
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button"
                                    id="logout-btn"
                                    class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MENU MOBILE (DROPDOWN) --}}
        <div id="mobile-menu"
             class="md:hidden hidden pb-4">
            <div class="mt-2 rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">

                <a href="{{ url('/seller/dashboard') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/dashboard') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Beranda
                </a>

                <a href="{{ url('/seller/orders') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/orders*') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Pesanan
                </a>

                <a href="{{ url('/seller/products') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/products*') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Produk
                </a>

                <a href="{{ url('/seller/categories') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/categories*') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Kategori
                </a>

                <a href="{{ url('/seller/balance') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/balance') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Saldo
                </a>

                <a href="{{ url('/seller/withdrawals') }}"
                   class="block px-5 py-3 text-sm font-medium {{ request()->is('seller/withdrawals*') ? 'text-pink-600 bg-pink-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    Penarikan
                </a>

                <div class="border-t border-gray-100">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Profil Saya
                    </a>

                    <button type="button" id="logout-btn-mobile"
                            class="w-full text-left px-5 py-3 text-sm font-medium text-red-600 hover:bg-red-50">
                        Keluar
                    </button>
                </div>
            </div>
        </div>

    </div>
</nav>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ========= MOBILE MENU =========
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconBurger = document.getElementById('icon-burger');
    const iconClose = document.getElementById('icon-close');

    function toggleMobileMenu(forceClose = false) {
        const isHidden = mobileMenu.classList.contains('hidden');

        if (forceClose) {
            mobileMenu.classList.add('hidden');
            iconBurger.classList.remove('hidden');
            iconClose.classList.add('hidden');
            return;
        }

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            iconBurger.classList.add('hidden');
            iconClose.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
            iconBurger.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    }

    if (mobileBtn) {
        mobileBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleMobileMenu();
        });
    }

    // ========= PROFILE DROPDOWN =========
    const profilBtn = document.getElementById('profil-btn');
    const profilMenu = document.getElementById('profil-menu');

    if (profilBtn && profilMenu) {
        profilBtn.addEventListener('click', (e) => {
            e.preventDefault();
            profilMenu.classList.toggle('hidden');
        });
    }

    // ========= LOGOUT CONFIRM (DESKTOP + MOBILE) =========
    const logoutBtn = document.getElementById('logout-btn');
    const logoutBtnMobile = document.getElementById('logout-btn-mobile');
    const logoutForm = document.getElementById('logout-form');

    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari akun?',
            text: 'Anda akan keluar dari Panel Seller.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                logoutForm.submit();
            }
        });
    }

    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            confirmLogout();
        });
    }

    if (logoutBtnMobile && logoutForm) {
        logoutBtnMobile.addEventListener('click', function (e) {
            e.preventDefault();
            confirmLogout();
        });
    }

    // ========= CLICK OUTSIDE CLOSE =========
    document.addEventListener('click', (e) => {
        // close profile dropdown
        if (profilBtn && profilMenu && !profilBtn.contains(e.target) && !profilMenu.contains(e.target)) {
            profilMenu.classList.add('hidden');
        }

        // close mobile menu if click outside navbar area
        const nav = document.querySelector('nav');
        if (nav && mobileMenu && !nav.contains(e.target)) {
            toggleMobileMenu(true);
        }
    });
</script>
