<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== Auth::id(), 403);

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = \App\Models\Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}
