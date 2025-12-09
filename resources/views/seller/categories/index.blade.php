<x-app-layout>

<div class="min-h-screen bg-[#fce8f4] p-10">

    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Product Categories</h2>

    <a href="{{ route('seller.categories.create') }}"
       class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg shadow">
        + Add Category
    </a>

    <div class="bg-white rounded-xl border border-pink-200 shadow-sm p-6 mt-6">

        <table class="w-full text-left">
            <thead class="text-gray-500 text-sm border-b">
                <tr>
                    <th class="py-3">Name</th>
                    <th class="py-3">Description</th>
                    <th class="py-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $cat)
                <tr class="border-b">
                    <td class="py-3">{{ $cat->name }}</td>
                    <td class="py-3">{{ $cat->description ?? '-' }}</td>
                    <td class="py-3">

                        <a href="{{ route('seller.categories.edit', $cat->id) }}"
                           class="text-pink-600 hover:underline mr-3">
                            Edit
                        </a>

                        <form action="{{ route('seller.categories.delete', $cat->id) }}" 
                            method="POST" 
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="text-red-500 delete-btn">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">
                        No categories found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

{{-- =============================== --}}
{{-- SWEETALERT DELETE CONFIRMATION --}}
{{-- =============================== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: "Delete this category?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

</x-app-layout>