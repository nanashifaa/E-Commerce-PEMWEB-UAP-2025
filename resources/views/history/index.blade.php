@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <h1 class="text-3xl font-semibold mb-6 text-gray-800">Riwayat Transaksi</h1>

    @if ($transactions->isEmpty())
        <p class="text-gray-500">Belum ada transaksi.</p>
    @endif

    <div class="space-y-5">

        @foreach ($transactions as $trx)
        <div class="bg-white shadow-md border rounded-xl p-5 hover:shadow-lg transition">

            <div class="flex justify-between mb-3">
                <div>
                    <p class="text-gray-600 text-sm">Kode Transaksi</p>
                    <p class="text-lg font-semibold">{{ $trx->code }}</p>
                </div>

                <a href="{{ route('history.show', $trx->id) }}"
                   class="text-pink-600 font-medium hover:underline">
                    Lihat Detail →
                </a>
            </div>

            <p class="text-gray-700">
                Toko: <span class="font-medium">{{ $trx->store->name }}</span>
            </p>

            <p class="text-gray-700">
                Total: <span class="font-semibold text-pink-600">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
            </p>

            <span class="inline-block mt-2 px-3 py-1 text-xs rounded-lg
                @if($trx->payment_status === 'paid')
                    bg-green-100 text-green-700
                @else
                    bg-yellow-100 text-yellow-700
                @endif">
                {{ ucfirst($trx->payment_status) }}
            </span>

        </div>
        @endforeach

    </div>

</div>

@endsection
