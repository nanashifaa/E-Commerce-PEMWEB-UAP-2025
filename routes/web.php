<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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
use App\Http\Controllers\Admin\AdminWithdrawalController;

Route::get('/', function () {
    return redirect()->route('home');
});

// Home untuk guest & member
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'list'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/search', [ProductController::class, 'search'])->name('product.search');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'seller') return redirect()->route('seller.dashboard');

    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'access:member'])->group(function () {

    // Transactions
    Route::get('/history', [TransactionHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [TransactionHistoryController::class, 'show'])->name('history.show');

    // Wallet
    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'submitTopup'])->name('wallet.topup.submit');
    Route::get('/wallet/topup/confirm/{topup}', [WalletController::class, 'confirmTopup'])->name('wallet.topup.confirm');

    // Checkout
    Route::get('/checkout/success', fn() => view('checkout.success'))->name('checkout.success');
    Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Cart
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

    // Cart Checkout
    Route::get('/checkout-cart', [CheckoutController::class, 'cartCheckout'])->name('checkout.cart');
    Route::post('/checkout-cart/process', [CheckoutController::class, 'processCart'])->name('checkout.cart.process');

    // Payment
    Route::get('/payment', [WalletController::class, 'paymentPage'])->name('payment.page');
    Route::post('/payment/confirm', [WalletController::class, 'confirmPayment'])->name('payment.confirm');
});

Route::middleware(['auth', 'access:seller'])->group(function () {

    Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/seller/profile', [SellerProfileController::class, 'index']);

    // Categories
    Route::get('/seller/categories', [CategoryController::class, 'index'])->name('seller.categories.index');
    Route::get('/seller/categories/create', [CategoryController::class, 'create'])->name('seller.categories.create');
    Route::post('/seller/categories/store', [CategoryController::class, 'store'])->name('seller.categories.store');
    Route::get('/seller/categories/{category}/edit', [CategoryController::class, 'edit'])->name('seller.categories.edit');
    Route::put('/seller/categories/{category}', [CategoryController::class, 'update'])->name('seller.categories.update');
    Route::delete('/seller/categories/{category}', [CategoryController::class, 'destroy'])->name('seller.categories.delete');

    // Products (SELLER)
    Route::get('/seller/products', [ProductController::class, 'sellerIndex'])->name('seller.products.index');
    Route::get('/seller/products/create', [ProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products/store', [ProductController::class, 'store'])->name('seller.products.store');
    Route::get('/seller/products/{product}/edit', [ProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/seller/products/{product}', [ProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/seller/products/{product}', [ProductController::class, 'destroy'])->name('seller.products.delete');

    // Orders
    Route::get('/seller/orders', [OrderController::class, 'index'])->name('seller.orders.index');
    Route::get('/seller/orders/{id}', [OrderController::class, 'show'])->name('seller.orders.show');

    // Withdrawals (SELLER)
    Route::get('/seller/withdrawals', [WithdrawalController::class, 'index'])->name('seller.withdrawals.index');
    Route::post('/seller/withdrawals', [WithdrawalController::class, 'store'])->name('seller.withdrawals.store');

    // Balance
    Route::get('/seller/balance', [BalanceController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.register.process');
});

Route::middleware(['auth', 'access:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // ✅ TAMBAHAN: Withdrawals (ADMIN)
    Route::get('/admin/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::get('/admin/withdrawals/{id}', [AdminWithdrawalController::class, 'show'])->name('admin.withdrawals.show');
    Route::post('/admin/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::post('/admin/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');

    // Verification
    Route::get('/admin/verification', [VerificationController::class, 'index']);
    Route::post('/admin/verification/approve/{store}', [VerificationController::class, 'approve']);
    Route::post('/admin/verification/reject/{store}', [VerificationController::class, 'reject']);

    // Admin user management
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{user}/update', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'delete'])->name('admin.users.delete');
});

require __DIR__ . '/auth.php';
