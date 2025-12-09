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
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TransactionHistoryController;

// PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// USER DASHBOARD (default laravel)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// SELLER DASHBOARD
Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])
    ->middleware(['auth', 'access:seller'])
    ->name('seller.dashboard');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| MEMBER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'access:member'])->group(function () {

    Route::get('/checkout/success', fn() => view('checkout.success'))->name('checkout.success');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/history', [TransactionHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [TransactionHistoryController::class, 'show'])->name('history.show');

    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'submitTopup'])->name('wallet.topup.submit');
   Route::get('/wallet/topup/confirm/{topup}', [WalletController::class, 'confirmTopup'])
         ->name('wallet.topup.confirm');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
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
*/
Route::middleware(['auth', 'access:seller'])->group(function () {

    // REGISTER TOKO
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.register.process');

    // MENU SELLER
    Route::get('/seller/profile', [SellerProfileController::class, 'index']);

    Route::get('/seller/categories', [CategoryController::class, 'index']);
       Route::get('/seller/products', [ProductController::class, 'index'])
        ->name('seller.products.index');

    Route::get('/seller/products/create', [ProductController::class, 'create'])
        ->name('seller.products.create');

    Route::post('/seller/products/store', [ProductController::class, 'store'])
        ->name('seller.products.store');

    Route::get('/seller/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('seller.products.edit');

    Route::put('/seller/products/{product}', [ProductController::class, 'update'])
        ->name('seller.products.update');

    Route::delete('/seller/products/{product}', [ProductController::class, 'destroy'])
        ->name('seller.products.delete');
        
    Route::get('/seller/orders', [OrderController::class, 'index']);
    Route::get('/seller/withdrawals', [WithdrawalController::class, 'index']);
    Route::get('/seller/balance', [BalanceController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'access:admin'])->group(function () {

    // DASHBOARD
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // VERIFIKASI TOKO
    Route::get('/admin/verification', [VerificationController::class, 'index']);
    Route::post('/admin/verification/approve/{store}', [VerificationController::class, 'approve']);
    Route::post('/admin/verification/reject/{store}', [VerificationController::class, 'reject']);

    // USERS
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{user}/update', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'delete'])->name('admin.users.delete');
});

require __DIR__.'/auth.php';
