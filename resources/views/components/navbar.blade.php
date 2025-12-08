<nav class="w-full px-8 py-4 flex justify-between items-center shadow-sm bg-white">
    <a href="/" class="text-xl font-semibold text-pink-600">Cheap & Use.</a>

    <div class="flex items-center gap-6">
        <a href="/history" class="text-gray-700 hover:text-pink-600">History</a>
        
        @auth
             <a href="/" class="text-gray-700 hover:text-pink-600">Home</a>
               {{-- LOGOUT BUTTON --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button 
                    class="text-gray-700 hover:text-red-600 transition font-medium">
                    Logout
                </button>
            </form>
        @else
            <a href="/login" class="text-gray-700 hover:text-pink-600">Login</a>
        @endauth
    </div>
</nav>
