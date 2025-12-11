<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-gray-50">

    {{-- TOPBAR --}}
    <header class="bg-white shadow-sm border-b border-gray-100 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
        <h1 class="text-xl font-bold text-gray-800 tracking-tight">Seller Dashboard</h1>

        <div class="flex items-center gap-4">
            <div class="text-right hidden md:block">
                <span class="block text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                <span class="block text-xs text-gray-500">Seller Account</span>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                 class="w-10 h-10 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-100">
        </div>
    </header>

    <div class="flex max-w-[1600px] mx-auto">

        {{-- SIDEBAR --}}
        <div class="w-64 flex-shrink-0 min-h-[calc(100vh-73px)] bg-white border-r border-gray-100 pt-8 hidden lg:block">
             @include('seller.sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 lg:p-12">

            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Orders</h2>
                    <p class="text-gray-500 mt-2">Manage and track your customer orders efficiently.</p>
                </div>
                
                {{-- Optional: Add filters or export buttons here in future --}}
            </div>

            {{-- ORDERS TABLE --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="py-5 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order Code</th>
                                <th class="py-5 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="py-5 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="py-5 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-5 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">
                            @forelse ($orders as $order)

                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="py-5 px-6">
                                    <span class="font-medium text-gray-900">#{{ $order->code }}</span>
                                </td>
                                <td class="py-5 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ substr($order->buyer->name, 0, 1) }}
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $order->buyer->name }}</span>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <span class="font-bold text-gray-900">
                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="py-5 px-6">
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                            'paid' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                            'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                            'cancelled' => 'bg-red-50 text-red-700 ring-red-600/10',
                                            default => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                        };
                                        $statusLabel = ucfirst($order->status);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="py-5 px-6 text-right">
                                    <a href="{{ route('seller.orders.show', $order->id) }}"
                                       class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform group-hover:translate-x-1">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">No orders found</p>
                                        <p class="text-sm">You haven't received any orders yet.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

    </div>

</div>

</x-app-layout>
