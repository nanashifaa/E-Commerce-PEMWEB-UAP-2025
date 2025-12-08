@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-pink-50 flex justify-center py-12">

    <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl p-8 border border-pink-200">

        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">
            Daftar Toko Baru
        </h2>

        {{-- FORM REGISTER STORE --}}
        <form action="{{ route('store.register.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Store Name --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Nama Toko</label>
                <input type="text" name="name" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400">
            </div>

            {{-- Logo --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Logo Toko</label>
                <input type="file" name="logo" accept="image/*"
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50">
            </div>

            {{-- About --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Deskripsi Toko</label>
                <textarea name="about" rows="4" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400"></textarea>
            </div>

            {{-- Address --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Alamat Toko</label>
                <input type="text" name="address" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400">
            </div>

            {{-- Phone --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400">
            </div>

            {{-- City --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Kota</label>
                <input type="text" name="city" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400">
            </div>

            {{-- Postal Code --}}
            <div class="mb-4">
                <label class="font-medium text-gray-700">Kode Pos</label>
                <input type="text" name="postal_code" required
                    class="mt-1 w-full p-3 rounded-lg border border-pink-300 bg-pink-50 focus:ring-2 focus:ring-pink-400">
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full py-3 font-semibold rounded-lg bg-pink-500 text-white hover:bg-pink-600 shadow">
                Daftarkan Toko
            </button>

        </form>
    </div>

</div>

@endsection
