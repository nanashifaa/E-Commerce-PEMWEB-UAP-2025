<?php

namespace App\Http\Controllers;

use App\Models\WalletTopup;
use Illuminate\Http\Request;

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

        if ((float)$request->amount !== (float)$transaction->grand_total) {
            return back()->withErrors("Nominal pembayaran tidak sesuai.");
        }

        $transaction->update([
            'payment_status' => 'paid'
        ]);

        return redirect('/checkout/success')->with('success', 'Pembayaran berhasil!');
    }

    /*
    |--------------------------------------------------------------------------
    | TOPUP SALDO E-WALLET (MEMBER)
    |--------------------------------------------------------------------------
    */

    // FORM TOPUP
    public function topup()
    {
        $user = auth()->user();

        // ✅ biar blade kamu bisa pakai $wallet->balance
        return view('wallet.topup', [
            'wallet' => $user
        ]);
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
        // ✅ pastikan topup milik user yg login
        if ($topup->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($topup->status !== 'pending') {
            return redirect()->route('wallet.topup')->with('success', 'Top up sudah diproses sebelumnya.');
        }

        // Update status topup
        $topup->update([
            'status' => 'paid',
        ]);

        // ✅ Refresh user biar ambil saldo terbaru dari DB
        $user = $topup->user()->first();

        // Tambahkan saldo user
        $user->update([
            'balance' => ((float)($user->balance ?? 0)) + ((float)$topup->amount),
        ]);

        // ✅ Redirect ke halaman topup biar saldo langsung kelihatan
        return redirect()->route('wallet.topup')
            ->with('success', 'Top up berhasil dikonfirmasi & saldo sudah masuk.');
    }
}
