@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Kategori</h2>
                <p class="text-gray-500 mt-2">
                    Tambahkan kategori baru untuk produk Anda.
                </p>
            </div>

            <a href="{{ route('seller.categories.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-200 bg-white
                      text-gray-700 hover:bg-gray-50 text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 overflow-hidden">
            <div class="p-6 md:p-8">

                <form action="{{ route('seller.categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               placeholder="Contoh: Elektronik"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                      focus:border-pink-500 focus:ring-pink-500">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                                  placeholder="Deskripsi kategori (opsional)"
                                  class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                         focus:border-pink-500 focus:ring-pink-500">{{ old('description') }}</textarea>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-full text-sm font-semibold text-white
                                       bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                            Simpan Kategori
                        </button>

                        <a href="{{ route('seller.categories.index') }}"
                           class="px-6 py-2.5 rounded-full text-sm font-semibold text-gray-700
                                  bg-white border border-gray-200 hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
