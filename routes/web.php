<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDashboardController; // ← TAMBAHKAN INI


// Public page
Route::get('/', function () {
    return view('welcome');
});

// User Dashboard (for all logged-in users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| MEMBER (formerly buyer/customer)
|--------------------------------------------------------------------------
| Role in DB → 'member'
*/

Route::middleware(['auth', 'access:member'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/wallet/topup', [WalletController::class, 'topup']);
});

/*
|--------------------------------------------------------------------------
| SELLER
|--------------------------------------------------------------------------
| Role in DB → 'seller'
*/

Route::middleware(['auth', 'access:seller'])->group(function () {
    Route::get('/store/register', [StoreController::class, 'create']);
    Route::get('/seller/profile', [SellerProfileController::class, 'index']);
    Route::get('/seller/categories', [CategoryController::class, 'index']);
    Route::get('/seller/products', [ProductController::class, 'index']);
    Route::get('/seller/orders', [OrderController::class, 'index']);
    Route::get('/seller/withdrawals', [WithdrawalController::class, 'index']);
    Route::get('/seller/balance', [BalanceController::class, 'index']);

    // Seller dashboard
    
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Role in DB → 'admin'
*/

Route::middleware(['auth', 'access:admin'])->group(function () {

    // Admin dashboard (PASTI BERFUNGSI SEKARANG)
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Store verification
    Route::get('/admin/verification', [VerificationController::class, 'index']);
    Route::post('/admin/verification/approve/{store}', [VerificationController::class, 'approve']);
    Route::post('/admin/verification/reject/{store}', [VerificationController::class, 'reject']);

    // User management
    Route::get('/admin/users', [AdminUserController::class, 'index']);

    Route::get('/admin/stores', [AdminStoreController::class, 'index'])
    ->middleware(['auth', 'access:admin']);


});

require __DIR__.'/auth.php';
