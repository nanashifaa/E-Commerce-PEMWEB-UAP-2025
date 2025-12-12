@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">
                    Tambah Produk
                </h2>
                <p class="text-gray-500 mt-2">
                    Lengkapi informasi produk untuk mulai dijual di toko Anda.
                </p>
            </div>

            <a href="{{ route('seller.products.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-sm font-semibold transition">
                ← Kembali ke Produk
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 overflow-hidden">
            <div class="p-6 md:p-8">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seller.products.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               placeholder="Contoh: Sepatu Sneakers"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                    </div>

                    {{-- KATEGORI + KONDISI --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="product_category_id" required
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                                <option value="">-- Pilih kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('product_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Kondisi <span class="text-red-500">*</span>
                            </label>
                            <select name="condition" required
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                                <option value="">-- Pilih kondisi --</option>
                                <option value="new"  {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                    </div>

                    {{-- HARGA + STOK + BERAT --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" required min="0"
                                   value="{{ old('price') }}"
                                   placeholder="150000"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" required min="0"
                                   value="{{ old('stock') }}"
                                   placeholder="10"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Berat (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="weight" required min="0"
                                   value="{{ old('weight') }}"
                                   placeholder="500"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="4" required
                                  placeholder="Tulis deskripsi produk..."
                                  class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm">{{ old('description') }}</textarea>
                    </div>

                    {{-- FOTO --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Foto Produk
                        </label>
                        <input type="file" name="image[]" multiple accept="image/*"
                               class="w-full text-sm rounded-xl border-gray-200 bg-gray-50
                                      file:mr-4 file:py-2.5 file:px-4 file:rounded-full
                                      file:border-0 file:text-sm file:font-semibold
                                      file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100">
                        <p class="mt-1 text-xs text-gray-500">
                            Anda bisa mengunggah lebih dari satu foto (JPG/PNG/WebP). Boleh dikosongkan.
                        </p>

                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('image.*')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-full text-sm font-semibold
                                       text-white bg-pink-600 hover:bg-pink-700 transition">
                            Simpan Produk
                        </button>

                        <a href="{{ route('seller.products.index') }}"
                           class="px-6 py-2.5 rounded-full text-sm font-semibold
                                  text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition">
                            Batalkan
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
