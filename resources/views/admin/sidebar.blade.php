<aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <div class="px-6 py-5 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-3 py-2 rounded-lg
           {{ request()->routeIs('admin.dashboard') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.withdrawals.index') }}"
           class="flex items-center px-3 py-2 rounded-lg
           {{ request()->routeIs('admin.withdrawals.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>Withdrawals</span>
        </a>

        <a href="{{ url('/admin/users') }}"
           class="flex items-center px-3 py-2 rounded-lg
           {{ request()->is('admin/users*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>Manage Users</span>
        </a>

        <a href="{{ url('/admin/verification') }}"
           class="flex items-center px-3 py-2 rounded-lg
           {{ request()->is('admin/verification*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>Store Verification</span>
        </a>
    </nav>

    <div class="px-6 py-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left text-sm font-medium text-gray-600 hover:text-red-500">
                Logout
            </button>
        </form>
    </div>
</aside>
