@extends('layouts.public')

@section('content')
<div class="min-h-screen px-6 py-10 flex justify-center">

    <div class="w-full max-w-xl bg-white p-8 rounded-2xl shadow-md border">

        <h1 class="text-2xl font-bold text-pink-600 text-center mb-6">
            Pembayaran Virtual Account
        </h1>

        {{-- Transaction info --}}
        <div class="bg-pink-50 p-4 rounded-xl mb-5">
            <p class="text-gray-700 text-sm">Kode VA Kamu:</p>
            <p class="text-xl font-semibold text-pink-600">
                VA-{{ $transaction->id }}
            </p>

            <p class="mt-3 text-gray-700">Total Pembayaran:</p>
            <p class="text-2xl font-bold text-pink-600">
                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 mb-5 rounded-xl">
                @foreach ($errors->all() as $err)
                    <p>{{ $err }}</p>
                @endforeach
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('payment.confirm') }}" method="POST">
            @csrf

            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

            <div class="mb-4">
                <label class="font-medium text-gray-700">Masukkan Kode VA</label>
                <input type="text" name="va_code" placeholder="VA-{{ $transaction->id }}"
                       class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-pink-400 outline-none">
            </div>

            <div class="mb-4">
                <label class="font-medium text-gray-700">Nominal Transfer</label>
                <input type="number" name="amount" placeholder="{{ $transaction->grand_total }}"
                       class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-pink-400 outline-none">
            </div>

            <button type="submit"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white py-3 rounded-xl font-medium transition">
                Konfirmasi Pembayaran
            </button>
        </form>

    </div>

</div>
@endsection
