<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Semua route di sini diproteksi oleh middleware 'auth' dan 'is_admin'.
| Daftarkan middleware 'is_admin' di bootstrap/app.php (lihat komentar di bawah).
|
| Di bootstrap/app.php, tambahkan:
|   ->withMiddleware(function (Middleware $middleware) {
|       $middleware->alias(['is_admin' => \App\Http\Middleware\IsAdmin::class]);
|   })
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'is_admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', DashboardController::class)->name('dashboard');

        // Kategori
        Route::resource('categories', CategoryController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // Buku
        Route::resource('books', BookController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        // Orders — admin hanya bisa lihat & update status
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Verifikasi pembayaran
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::patch('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        Route::patch('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    });