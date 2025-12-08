@extends('layouts.public')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-pink-50 px-6 py-16">

    <div class="bg-white p-10 rounded-3xl shadow-lg border max-w-lg w-full text-center">

        {{-- ICON CHECK --}}
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center text-5xl">
                ✓
            </div>
        </div>

        <h1 class="text-3xl font-bold text-pink-600 mb-2">
            Pembayaran Berhasil! 🎉
        </h1>

        <p class="text-gray-600 text-base mb-6">
            Pesananmu sedang diproses oleh penjual.  
            Terima kasih sudah berbelanja di <span class="font-semibold text-pink-500">Cheap & Use</span> 💖
        </p>

        <a href="{{ url('/') }}"
           class="block w-full bg-pink-500 hover:bg-pink-600 text-white py-3 rounded-xl text-lg font-medium transition">
            Kembali ke Beranda
        </a>

        <a href="{{ url('/history') }}"
           class="block w-full mt-3 text-pink-600 hover:text-pink-700 font-medium">
            Lihat Riwayat Pembelian
        </a>

    </div>

</div>
@endsection
