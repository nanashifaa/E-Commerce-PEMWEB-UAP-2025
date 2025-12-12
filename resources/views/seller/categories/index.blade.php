@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Kategori Produk</h2>
                <p class="text-gray-500 mt-2">
                    Kelola kategori untuk memudahkan pengelompokan produk di toko Anda.
                </p>
            </div>

            <a href="{{ route('seller.categories.create') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-semibold
                      text-white bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-400/30 transition">
                + Tambah Kategori
            </a>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100">
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse ($categories as $cat)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-5 px-6 align-middle">
                                    <p class="font-semibold text-gray-900">{{ $cat->name }}</p>
                                </td>

                                <td class="py-5 px-6 align-middle">
                                    <p class="text-sm text-gray-600">
                                        {{ $cat->description ?: '-' }}
                                    </p>
                                </td>

                                <td class="py-5 px-6 text-right align-middle">
                                    <div class="inline-flex items-center gap-4">
                                        <a href="{{ route('seller.categories.edit', $cat->id) }}"
                                           class="text-sm font-medium text-pink-600 hover:text-pink-700 transition">
                                            Ubah
                                        </a>

                                        <form action="{{ route('seller.categories.delete', $cat->id) }}"
                                              method="POST"
                                              class="inline delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                    class="text-sm font-medium text-red-600 hover:text-red-700 transition delete-btn">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">Belum ada kategori</p>
                                        <p class="text-sm text-gray-500">
                                            Silakan tambahkan kategori untuk produk Anda.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION (kalau pakai paginate) --}}
            @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

{{-- SWEETALERT DELETE CONFIRMATION --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: "Hapus kategori ini?",
                text: "Tindakan ini tidak dapat dibatalkan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>

@endsection
