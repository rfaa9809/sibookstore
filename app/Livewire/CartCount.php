<?php

namespace App\Livewire;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->syncCount();
    }

    /**
     * Dengarkan event 'cart-updated' yang di-dispatch AddToCart & CartList.
     * Otomatis update badge tanpa reload halaman.
     */
    #[On('cart-updated')]
    public function syncCount(): void
    {
        $this->count = Auth::check()
            ? CartItem::where('user_id', Auth::id())->sum('quantity')
            : 0;
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}