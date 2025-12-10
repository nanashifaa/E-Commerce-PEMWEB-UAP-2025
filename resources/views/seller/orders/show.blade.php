<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }} #{{ $order->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4"><strong>Customer:</strong> {{ $order->buyer->name }}</p>
                    <p class="mb-4"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <p class="mb-4"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    
                    <h3 class="text-lg font-bold mt-6 mb-2">Items</h3>
                    <ul class="list-disc pl-5">
                        @foreach($order->items as $item)
                            <li>
                                {{ $item->product->name }} x {{ $item->quantity }} - Rp {{ number_format($item->price, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
