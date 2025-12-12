@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">
                    Products
                </h2>
                <p class="text-gray-500 mt-2">
                    Manage all products in your store.
                </p>
            </div>

            <a href="{{ route('seller.products.create') }}"
               class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-pink-400/30 transition">
                <span class="text-lg leading-none">＋</span>
                <span>Add Product</span>
            </a>
        </div>

        {{-- PRODUCTS TABLE --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Product</th>
                            <th class="py-3.5 px-6">Price</th>
                            <th class="py-3.5 px-6">Stock</th>
                            <th class="py-3.5 px-6 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse ($products as $p)
                            @php
                                $firstImage = $p->productImages->first();
                                $imageUrl = $firstImage
                                    ? asset('storage/' . $firstImage->image)
                                    : asset('images/no-image.png'); // ganti jika mau
                            @endphp

                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                {{-- PRODUCT --}}
                                <td class="py-4 px-6 align-middle">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 shadow-sm border border-gray-200">
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="{{ $p->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 line-clamp-1">
                                                {{ $p->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                ID: {{ $p->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- PRICE --}}
                                <td class="py-4 px-6 align-middle">
                                    <span class="font-semibold text-pink-600">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- STOCK --}}
                                <td class="py-4 px-6 align-middle">
                                    @php
                                        $stockClass = $p->stock <= 3
                                            ? 'text-amber-700 bg-amber-50'
                                            : 'text-emerald-700 bg-emerald-50';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $stockClass }}">
                                        Stock: {{ $p->stock }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td class="py-4 px-6 align-middle text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('seller.products.edit', $p->id) }}"
                                           class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                            Edit
                                        </a>

                                        <form action="{{ route('seller.products.delete', $p->id) }}"
                                              method="POST"
                                              class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                class="text-sm font-medium text-red-500 hover:text-red-600 hover:underline delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 px-6 text-center text-gray-500 text-sm">
                                    No products found. Start by adding a new product.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/70">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            Swal.fire({
                title: "Delete this product?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest(".delete-form").submit();
                }
            });
        });
    });
});
</script>
@endpush
