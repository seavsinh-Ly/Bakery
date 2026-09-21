<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BakeryController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/invite/accept/{token}', [InvitationController::class, 'accept'])->name('invite.accept');
    Route::post('/invite/accept/{token}', [InvitationController::class, 'registerInvitedAdmin'])->name('invite.accept.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/bakery', [BakeryController::class, 'DisplayBakeryMenu'])->name('bakery.menu');
    Route::get('/shop/{slug}', [CustomerDashboardController::class, 'showProduct'])->name('customer.product.show');

    Route::middleware('customer')->group(function () {
        Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
        Route::get('/shop', [CustomerDashboardController::class, 'shop'])->name('customer.shop');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::get('/admin/invitations', [InvitationController::class, 'index'])->name('admin.invitations.index');
        Route::post('/admin/invitations', [InvitationController::class, 'store'])->name('admin.invitations.store');
        Route::post('/admin/invitations/{invitation}/approve', [InvitationController::class, 'approve'])->name('admin.invitations.approve');
        Route::post('/admin/invitations/{invitation}/reject', [InvitationController::class, 'reject'])->name('admin.invitations.reject');

        Route::get('/create-bakery', [BakeryController::class, 'createBakeryForm'])->name('bakery.create');
        Route::post('/create-bakery', [BakeryController::class, 'storeBakeryItem'])->name('bakery.store');
        Route::delete('/bakery/{id}', [BakeryController::class, 'deleteBakeryItem'])->name('bakery.delete');
        Route::get('/bakery/{id}/edit', [BakeryController::class, 'editBakeryItem'])->name('bakery.edit');
        Route::put('/bakery/{id}', [BakeryController::class, 'updateBakeryItem'])->name('bakery.update');
    });
});
