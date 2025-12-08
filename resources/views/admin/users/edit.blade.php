@extends('admin.layout')

@section('content')

<div class="max-w-xl space-y-6">

    <h2 class="text-2xl font-bold text-gray-800">Edit User Role</h2>

    <div class="bg-white border border-pink-200 rounded-2xl shadow-sm p-6">

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-gray-600 text-sm mb-1">Name</label>
                <input type="text"
                       class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                       value="{{ $user->name }}"
                       disabled>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-600 text-sm mb-1">Email</label>
                <input type="text"
                       class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                       value="{{ $user->email }}"
                       disabled>
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block text-gray-600 text-sm mb-1">Role</label>

                <select name="role"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300">

                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>

                </select>
            </div>

            {{-- Save Button --}}
            <button class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-lg font-semibold transition">
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection
