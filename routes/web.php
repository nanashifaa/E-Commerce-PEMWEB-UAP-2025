<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
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
use App\Http\Controllers\TransactionHistoryController;



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
    Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/history', [TransactionHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [TransactionHistoryController::class, 'show'])->name('history.show');
    Route::get('/wallet/topup', [WalletController::class, 'topup']);
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/payment', [WalletController::class, 'paymentPage'])->name('payment.page');
Route::post('/payment/confirm', [WalletController::class, 'confirmPayment'])->name('payment.confirm');



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

        Route::middleware(['auth', 'access:admin'])->group(function () {

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{user}/update', [AdminUserController::class, 'update'])->name('admin.users.update');

    Route::delete('/admin/users/{user}', [AdminUserController::class, 'delete'])
    ->name('admin.users.delete');

    Route::get('/admin/verification', [VerificationController::class, 'index']);
    Route::post('/admin/verification/approve/{store}', [VerificationController::class, 'approve']);
    Route::post('/admin/verification/reject/{store}', [VerificationController::class, 'reject']);

});
});

require __DIR__.'/auth.php';
