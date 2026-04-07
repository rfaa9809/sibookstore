<?php

namespace App\Http\Controllers;

class CartController extends Controller
{
    /**
     * Halaman cart — semua logika (update qty, remove, total)
     * ditangani Livewire CartList component.
     */
    public function index()
    {
        return view('cart');
    }
}