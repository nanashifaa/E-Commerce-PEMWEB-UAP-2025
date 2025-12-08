@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <a href="{{ route('history.index') }}" class="text-pink-600 mb-6 inline-block hover:underline">
        ← Kembali
    </a>

    <div class="bg-white shadow-md border rounded-xl p-7">

        <h1 class="text-2xl font-semibold mb-4">Detail Transaksi</h1>

        <p class="text-gray-600">Kode: <strong>{{ $transaction->code }}</strong></p>
        <p class="text-gray-600">Toko: <strong>{{ $transaction->store->name }}</strong></p>
        <p class="text-gray-600 mb-5">
            Total: 
            <strong class="text-pink-600">
                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
            </strong>
        </p>

        <h2 class="font-semibold text-lg mb-3">Produk Dibeli:</h2>

        <div class="space-y-4">

            @foreach ($transaction->transactionDetails as $detail)
            <div class="border rounded-lg p-4 bg-gray-50">

                <p class="font-semibold text-gray-800">{{ $detail->product->name }}</p>

                <p class="text-gray-600">Qty: {{ $detail->qty }}</p>
                <p class="text-gray-600">
                    Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </p>

            </div>
            @endforeach

        </div>

    </div>

</div>

@endsection
