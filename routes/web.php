<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['access:buyer|customer'])->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/wallet/topup', [WalletController::class, 'topup']);

});

Route::middleware(['access:seller'])->group(function () {

    Route::get('/store/register', [StoreController::class, 'create']);
    Route::get('/seller/profile', [SellerProfileController::class, 'index']);
    Route::get('/seller/categories', [CategoryController::class, 'index']);
    Route::get('/seller/products', [ProductController::class, 'index']);
    Route::get('/seller/orders', [OrderController::class, 'index']);
    Route::get('/seller/withdrawals', [WithdrawalController::class, 'index']);
    Route::get('/seller/balance', [BalanceController::class, 'index']);

});

Route::middleware(['access:admin'])->group(function () {

    Route::get('/admin/verification', [VerificationController::class, 'index']);
    Route::post('/admin/verification/approve/{store}', [VerificationController::class, 'approve']);
    Route::post('/admin/verification/reject/{store}', [VerificationController::class, 'reject']);

    Route::get('/admin/users', [AdminUserController::class, 'index']);

});


// Admin Dashboard
Route::middleware(['access:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Seller Dashboard
Route::middleware(['access:seller'])->get('/seller/dashboard', function () {
    return view('seller.dashboard');
})->name('seller.dashboard');

require __DIR__.'/auth.php';
