<?php

namespace App\Livewire;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartList extends Component
{
    /**
     * Update quantity item di cart.
     * Jika qty diturunkan ke 0 atau kurang, item otomatis dihapus.
     */
    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        $item = CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($quantity < 1) {
            $item->delete();
        } else {
            // Pastikan qty tidak melebihi stok buku
            $maxStock = $item->book->stock;
            $item->update(['quantity' => min($quantity, $maxStock)]);
        }

        $this->dispatch('cart-updated');
    }

    public function remove(int $cartItemId): void
    {
        CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->delete();

        $this->dispatch('cart-updated');
    }

    public function clearCart(): void
    {
        CartItem::where('user_id', Auth::id())->delete();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $items = CartItem::with('book.category')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum(fn ($item) => $item->subtotal());

        return view('livewire.cart-list', compact('items', 'total'));
    }
}