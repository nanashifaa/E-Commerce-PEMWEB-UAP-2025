<x-app-layout>

<style>
    body, * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    {{-- TOPBAR --}}
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Products</h1>

        <a href="{{ route('seller.products.create') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg shadow">
            + Add Product
        </a>
    </header>

    <div class="flex">

        {{-- SIDEBAR --}}
        @include('seller.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-10">

            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Your Products</h2>

            {{-- TABLE --}}
            <div class="bg-white rounded-xl border border-pink-200 shadow-sm p-6">

                <table class="w-full text-left">
                    <thead class="text-gray-500 text-sm border-b">
                        <tr>
                            <th class="py-3">Image</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Stock</th>
                            <th class="py-3 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $p)
                        <tr class="border-b">

                            {{-- IMAGE --}}
                            <td class="py-3">
                                <img src="{{ asset('storage/' . ($p->productImages->first()->image ?? 'default.jpg')) }}"
                                     class="w-14 h-14 rounded-lg object-cover shadow"
                                     style="width: 56px; height: 56px;">
                            </td>

                            {{-- NAME --}}
                            <td class="py-3 font-medium">{{ $p->name }}</td>

                            {{-- PRICE --}}
                            <td class="py-3 text-pink-600">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>

                            {{-- STOCK --}}
                            <td class="py-3">{{ $p->stock }}</td>

                            {{-- ACTION --}}
                            <td class="py-3 text-right space-x-3">

                                <a href="{{ route('seller.products.edit', $p->id) }}"
                                   class="text-pink-500 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('seller.products.delete', $p->id) }}"
                                      method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="text-red-500 hover:underline delete-btn">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                No products found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </main>
    </div>
</div>

{{-- SWEETALERT DELETE --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
</script>

</x-app-layout>
