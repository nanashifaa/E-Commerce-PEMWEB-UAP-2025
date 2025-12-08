@extends('admin.layout')

@section('content')

<div class="space-y-8 w-full max-w-xl mx-auto">

    {{-- Title --}}
    <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>

    {{-- Card --}}
    <div class="bg-white shadow-sm border border-pink-200 rounded-2xl p-6">

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf

            {{-- NAME --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" value="{{ $user->name }}" disabled
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed">
            </div>

            {{-- EMAIL --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" value="{{ $user->email }}" disabled
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed">
            </div>

            {{-- ROLE --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>

                <select name="role"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-300 focus:border-pink-400">
                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-between items-center mt-8">

                <a href="{{ route('admin.users') }}"
                   class="text-gray-600 hover:text-gray-800 underline">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


{{-- SweetAlert Success --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#e11d48'
    });
</script>
@endif
@endpush
