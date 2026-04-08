<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController as UserOrderController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ContactMessageController;
use Livewire\Livewire;

Livewire::component('admin.category-table', \App\Livewire\Admin\CategoryTable::class);
Livewire::component('admin.book-table',     \App\Livewire\Admin\BookTable::class);
Livewire::component('admin.order-table',    \App\Livewire\Admin\OrderTable::class);
Livewire::component('admin.payment-table',  \App\Livewire\Admin\PaymentTable::class);
Livewire::component('admin.user-table',     \App\Livewire\Admin\UserTable::class);

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send')->middleware('auth');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/test', function () {
    return 'TEST OK';
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
});




Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');

    // Kategori
    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Buku
    Route::resource('books', AdminBookController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Orders — admin hanya bisa lihat & update status
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Verifikasi pembayaran
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::patch('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::patch('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('messages/{message}/read', [ContactMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])
    ->name('messages.destroy');

    Route::get('users', function () {
        return view('admin.users.index');
    })->name('users.index');
});
