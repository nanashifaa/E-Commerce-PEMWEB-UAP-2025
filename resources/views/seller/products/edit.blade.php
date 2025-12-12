@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Ubah Produk</h2>
                <p class="text-gray-500 mt-2">
                    Perbarui data produk:
                    <span class="font-semibold text-gray-800">"{{ $product->name }}"</span>
                </p>
            </div>

            <a href="{{ route('seller.products.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Produk
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 overflow-hidden">
            <div class="p-6 md:p-8">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                        <p class="font-semibold mb-2">Ada yang perlu diperbaiki:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seller.products.update', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required
                               value="{{ old('name', $product->name) }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                      focus:border-pink-500 focus:ring-pink-500">
                    </div>

                    {{-- KATEGORI + KONDISI --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="product_category_id" required
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                           focus:border-pink-500 focus:ring-pink-500">
                                <option value="">-- Pilih kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>
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
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                           focus:border-pink-500 focus:ring-pink-500">
                                <option value="">-- Pilih kondisi --</option>
                                <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>
                                    Baru
                                </option>
                                <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>
                                    Bekas
                                </option>
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
                                   value="{{ old('price', (int) $product->price) }}"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                          focus:border-pink-500 focus:ring-pink-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" required min="0"
                                   value="{{ old('stock', $product->stock) }}"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                          focus:border-pink-500 focus:ring-pink-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Berat (gram) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="weight" required min="0"
                                   value="{{ old('weight', $product->weight) }}"
                                   class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                          focus:border-pink-500 focus:ring-pink-500">
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5 text-sm
                                         focus:border-pink-500 focus:ring-pink-500">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- FOTO SAAT INI --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>

                        @if($product->productImages->count())
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->productImages as $img)
                                    <div class="w-20 h-20 rounded-xl overflow-hidden border border-gray-200 bg-gray-100">
                                        <img src="{{ asset('storage/' . $img->image_path) }}"
                                             class="w-full h-full object-cover"
                                             alt="Foto produk">
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Foto lama tidak otomatis terhapus.
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Belum ada foto.</p>
                        @endif
                    </div>

                    {{-- TAMBAH FOTO BARU --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Tambah Foto Baru
                        </label>
                        <input type="file" name="image[]" multiple accept="image/*"
                               class="w-full text-sm rounded-xl border-gray-200 bg-gray-50
                                      focus:border-pink-500 focus:ring-pink-500
                                      file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm
                                      file:font-semibold file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100">
                        <p class="mt-1 text-xs text-gray-500">
                            Anda bisa mengunggah lebih dari satu foto (JPG/PNG).
                        </p>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-semibold
                                       text-white bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('seller.products.index') }}"
                           class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-semibold
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
