@extends('admin.layout')

@section('content')

<div class="space-y-8">

    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-pink-200 shadow-sm p-6">

        <table class="w-full text-left text-sm">
            <thead class="border-b bg-pink-50 text-gray-600">
                <tr>
                    <th class="py-3 px-2">Name</th>
                    <th class="py-3 px-2">Email</th>
                    <th class="py-3 px-2">Role</th>
                    <th class="py-3 px-2">Store</th>
                    <th class="py-3 px-2 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- NAME --}}
                    <td class="py-3 px-2 font-medium">
                        {{ $user->name }}
                    </td>

                    {{-- EMAIL --}}
                    <td class="py-3 px-2">
                        {{ $user->email }}
                    </td>

                    {{-- ROLE BADGE --}}
                    <td class="py-3 px-2">

                        @if ($user->role === 'admin')
                            <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-lg">
                                Admin
                            </span>
                        @elseif ($user->role === 'seller')
                            <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-lg">
                                Seller
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-lg">
                                Member
                            </span>
                        @endif

                    </td>

                    {{-- STORE --}}
                    <td class="py-3 px-2">
                        @if ($user->store)
                            <span class="text-gray-900 font-medium">{{ $user->store->name }}</span>
                        @else
                            <span class="text-gray-400 italic">No Store</span>
                        @endif
                    </td>

                   {{-- ACTION --}}
<td class="py-3 px-2 text-right space-x-3">

    {{-- EDIT BUTTON --}}
    <a href="{{ route('admin.users.edit', $user->id) }}"
       class="text-pink-600 hover:underline font-medium">
        Edit
    </a>

    {{-- DELETE BUTTON --}}
    <form action="{{ route('admin.users.delete', $user->id) }}" 
          method="POST" 
          class="inline delete-form">
        @csrf
        @method('DELETE')

        <button type="button"
                class="text-red-500 hover:underline font-medium delete-btn">
            Delete
        </button>
    </form>

</td>
</tr>
@endforeach

</tbody>
</table>

</div>
</div>

@endsection


{{-- ========================= --}}
{{-- SWEETALERT SCRIPT (TAMBAHAN) --}}
{{-- ========================= --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.delete-btn').forEach(function (btn) {

        btn.addEventListener('click', function () {

            let form = this.closest('form');

            Swal.fire({
                title: "Are you sure?",
                text: "This user will be deleted permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, delete",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });

    });

});
</script>
@endpush
