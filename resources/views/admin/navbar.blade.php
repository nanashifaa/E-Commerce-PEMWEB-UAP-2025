<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
    <div>
        <p class="text-sm text-gray-500">Admin</p>
        <h2 class="text-lg font-semibold text-gray-900">Admin Panel</h2>
    </div>

    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-sm font-medium text-gray-900">
                {{ auth()->user()->name ?? 'Admin User' }}
            </p>
            <p class="text-xs text-gray-500">Administrator</p>
        </div>
        <div
            class="w-9 h-9 rounded-full bg-pink-500 flex items-center justify-center text-white text-sm font-semibold">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
    </div>
</header>
