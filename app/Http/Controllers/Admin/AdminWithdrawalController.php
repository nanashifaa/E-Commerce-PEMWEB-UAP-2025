<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status'); // optional filter

        $query = Withdrawal::with('storeBalance.store.user')->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        $withdrawals = $query->get();

        return view('admin.withdrawals.index', compact('withdrawals', 'status'));
    }

    public function show($id)
    {
        $withdrawal = Withdrawal::with('storeBalance.store.user')->findOrFail($id);
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    // APPROVE: hanya ubah status (saldo sudah dipotong saat seller request)
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $wd = Withdrawal::lockForUpdate()->findOrFail($id);

            if ($wd->status !== 'pending') {
                abort(403, 'Withdrawal already processed.');
            }

            $wd->update([
                'status' => 'approved',
            ]);

            // optional: update history remarks kalau ada
            $balance = StoreBalance::find($wd->store_balance_id);
            if ($balance && method_exists($balance, 'storeBalanceHistories')) {
                $balance->storeBalanceHistories()
                    ->where('reference_type', 'withdrawal')
                    ->where('reference_id', $wd->id)
                    ->latest()
                    ->first()?->update([
                        'remarks' => 'Withdrawal approved',
                    ]);
            }
        });

        return back()->with('success', 'Withdrawal approved.');
    }

    // REJECT: kembalikan saldo + ubah status
    public function reject(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($id, $request) {
            $wd = Withdrawal::with('storeBalance')->lockForUpdate()->findOrFail($id);

            if ($wd->status !== 'pending') {
                abort(403, 'Withdrawal already processed.');
            }

            // 1) kembalikan saldo
            $wd->storeBalance->increment('balance', $wd->amount);

            // 2) update status
            $wd->update([
                'status' => 'rejected',
            ]);

            // 3) optional: history
            if (method_exists($wd->storeBalance, 'storeBalanceHistories')) {
                $wd->storeBalance->storeBalanceHistories()->create([
                    'type'           => 'refund',
                    'amount'         => $wd->amount,
                    'remarks'        => 'Withdrawal rejected' . ($request->note ? (' - ' . $request->note) : ''),
                    'reference_type' => 'withdrawal',
                    'reference_id'   => $wd->id,
                ]);
            }
        });

        return back()->with('success', 'Withdrawal rejected and balance refunded.');
    }
}
