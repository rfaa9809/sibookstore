<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Single Action Controller untuk halaman dashboard admin.
     */
    public function __invoke()
    {
        $stats = [
            'total_books'       => Book::count(),
            'total_users'       => User::where('role', 'user')->count(),
            'total_orders'      => Order::count(),
            'pending_payments'  => Payment::where('status', 'uploaded')->count(),
            'unread_messages'   => ContactMessage::unread()->count(),
            'revenue'           => Payment::where('status', 'verified')->sum('amount'),
        ];

        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $pendingPayments = Payment::with(['order.user'])
            ->where('status', 'uploaded')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingPayments'));
    }
}