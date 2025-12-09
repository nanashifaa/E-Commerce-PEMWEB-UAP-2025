<aside class="w-60 min-h-screen bg-white border-r p-6 space-y-5 hidden md:block">

    <a href="/seller/dashboard" class="block text-pink-600 font-semibold">Dashboard</a>
    <a href="/seller/orders" class="block text-gray-600 hover:text-pink-600">Orders</a>
    <a href="/seller/products" class="block text-gray-600 hover:text-pink-600">Products</a>
    <a href="/seller/categories" class="block text-gray-600 hover:text-pink-600">Categories</a>
    <a href="/seller/balance" class="block text-gray-600 hover:text-pink-600">Balance</a>
    <a href="/seller/withdrawals" class="block text-gray-600 hover:text-pink-600">Withdrawals</a>

    <form method="POST" action="{{ route('logout') }}" class="pt-10">
        @csrf
        <button class="text-gray-500 hover:text-red-500">Logout</button>
    </form>

</aside>
