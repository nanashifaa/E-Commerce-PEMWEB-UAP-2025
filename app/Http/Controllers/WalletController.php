<?php

namespace App\Http\Controllers;

use App\Models\WalletTopup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAYMENT CHECKOUT — BIARKAN SEPERTI ASLI
    |--------------------------------------------------------------------------
    */
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
            'va_code'        => 'required',
            'amount'         => 'required|numeric',
        ]);

        $transaction = \App\Models\Transaction::findOrFail($request->transaction_id);

        $expectedVA = "VA-" . $transaction->id;

        if ($request->va_code !== $expectedVA) {
            return back()->withErrors("Kode VA salah.");
        }

        if ($request->amount != $transaction->grand_total) {
            return back()->withErrors("Nominal pembayaran tidak sesuai.");
        }

        $transaction->update([
            'payment_status' => 'paid'
        ]);

        return redirect('/checkout/success')->with('success', 'Pembayaran berhasil!');
    }

    /*
    |--------------------------------------------------------------------------
    | TOPUP SALDO E-WALLET
    |--------------------------------------------------------------------------
    */

    // FORM TOPUP
    public function topup()
    {
        return view('wallet.topup');
    }

    // PROSES TOPUP → Generate VA unik
    public function submitTopup(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10000'],
            'bank'   => ['required', 'string', 'max:50'],
        ]);

        $user = auth()->user();

        // Generate VA unik: 8808 + userID(4digit) + random 6 digit
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

    // KONFIRMASI TOPUP (AUTO PAID)
    public function confirmTopup(WalletTopup $topup)
    {
        if ($topup->status !== 'pending') {
            return back()->with('error', 'Topup sudah diproses sebelumnya.');
        }

        // Update status
        $topup->update([
            'status' => 'paid',
        ]);

        // Tambahkan saldo user
        $topup->user->update([
            'balance' => ($topup->user->balance ?? 0) + $topup->amount
        ]);

        return back()->with('success', 'Topup berhasil dikonfirmasi & saldo sudah masuk.');
    }
}
