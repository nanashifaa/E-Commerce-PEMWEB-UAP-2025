<?php

namespace App\Http\Controllers;
use App\Models\WalletTopup;
use Illuminate\Support\Str;
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
public function topup()
{
    return view('wallet.topup');
}

public function process(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1000',
        'bank' => 'required|string'
    ]);

    $user = auth()->user();

    // Tambah saldo langsung
    $user->balance = ($user->balance ?? 0) + $request->amount;
    $user->save();

    return back()->with('success', 'Top up berhasil! Saldo telah ditambahkan.');
}


public function submitTopup(Request $request)
{
    $request->validate([
        'amount' => ['required', 'numeric', 'min:10000'],
        'bank'   => ['required', 'string', 'max:50'],
    ]);

    $user = $request->user();

    // Generate VA unik sederhana
    // Format contoh: 8808 + user_id 4 digit + random 6 digit
    $base = '8808' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

    do {
        $va = $base . random_int(100000, 999999);
    } while (WalletTopup::where('va_number', $va)->exists());

    $topup = WalletTopup::create([
        'user_id'   => $user->id,
        'va_number' => $va,
        'bank'      => $request->bank,
        'amount'    => $request->amount,
        'status'    => 'pending',
    ]);

    return view('wallet.topup_success', compact('topup'));
}
public function confirmTopup(WalletTopup $topup)
{
    if ($topup->status !== 'pending') {
        return back()->with('error', 'Topup sudah diproses sebelumnya.');
    }

    // Update status menjadi paid
    $topup->update([
        'status' => 'paid',
    ]);

    // Tambahkan saldo kepada user
    $topup->user->update([
        'balance' => $topup->user->balance + $topup->amount
    ]);

    return back()->with('success', 'Topup berhasil dikonfirmasi & saldo sudah masuk.');
}

}
