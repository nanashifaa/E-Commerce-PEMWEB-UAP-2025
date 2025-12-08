<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function paymentPage(Request $request)
{
    $trxId = $request->trx;
    $transaction = \App\Models\Transaction::find($trxId);

    return view('payment.index', compact('transaction'));
}
public function confirmPayment(Request $request)
{
    $request->validate([
        'transaction_id' => 'required',
        'va_code' => 'required',
        'amount' => 'required|numeric',
    ]);

    $transaction = \App\Models\Transaction::findOrFail($request->transaction_id);

    // cek VA code benar
    $expectedVA = "VA-" . $transaction->id;

    if ($request->va_code !== $expectedVA) {
        return back()->withErrors("Kode VA salah.");
    }

    // cek nominal harus sama
    if ($request->amount != $transaction->grand_total) {
        return back()->withErrors("Nominal pembayaran tidak sesuai.");
    }

    // update status transaksi
    $transaction->payment_status = 'paid';
    $transaction->save();

    return redirect('/checkout/success')->with('success', 'Pembayaran berhasil!');
}

}
