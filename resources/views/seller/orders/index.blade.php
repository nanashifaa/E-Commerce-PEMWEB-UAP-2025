<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    {{-- TOPBAR --}}
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Orders</h1>

        <div class="flex items-center gap-3">
            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <img src="https://i.pravatar.cc/100"
                 class="w-10 h-10 rounded-full border border-pink-300 shadow-sm">
        </div>
    </header>

    <div class="flex">

        {{-- SIDEBAR --}}
        @include('seller.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-10">

            <h2 class="text-3xl font-semibold text-gray-800">Orders List</h2>
            <p class="text-gray-500 mb-6">Here are all customer orders for your store</p>

            {{-- ORDERS TABLE --}}
            <div class="bg-white rounded-xl border border-pink-200 shadow-sm p-6">

                <table class="w-full text-left">
                    <thead class="text-gray-500 text-sm border-b">
                        <tr>
                            <th class="py-3">Order Code</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)

                        <tr class="border-b">
                            <td class="py-3">{{ $order->code }}</td>
                            <td class="py-3">{{ $order->buyer->name }}</td>
                            <td class="py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>

                            <td class="py-3">
                                @if($order->status == 'pending')
                                    <span class="px-3 py-1 text-xs rounded-lg bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @elseif($order->status == 'paid')
                                    <span class="px-3 py-1 text-xs rounded-lg bg-blue-100 text-blue-700">
                                        Paid
                                    </span>
                                @elseif($order->status == 'completed')
                                    <span class="px-3 py-1 text-xs rounded-lg bg-green-100 text-green-700">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-lg bg-red-100 text-red-700">
                                        Cancelled
                                    </span>
                                @endif
                            </td>

                            <td class="py-3">
                                <a href="{{ route('seller.orders.show', $order->id) }}"
                                   class="text-pink-600 hover:underline">
                                    View Details
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                No orders found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </main>

    </div>

</div>

</x-app-layout>
