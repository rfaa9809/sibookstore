<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Kalau cart kosong, redirect balik ke cart
        $cartItems = CartItem::with('book')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjangmu masih kosong.');
        }

        return view('checkout.index');
    }
}