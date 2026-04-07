<?php

namespace App\Livewire;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AddToCart extends Component
{
    public int  $bookId;
    public int  $quantity   = 1;
    public bool $inCart     = false;
    public bool $showFeedback = false;

    public function mount(int $bookId): void
    {
        $this->bookId = $bookId;
        $this->syncCartState();
    }

    protected function syncCartState(): void
    {
        if (Auth::check()) {
            $this->inCart = CartItem::where('user_id', Auth::id())
                ->where('book_id', $this->bookId)
                ->exists();
        }
    }

    public function addToCart(): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login');
            return;
        }

        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $this->bookId],
            ['quantity' => DB::raw("quantity + {$this->quantity}")]
        );

        $this->inCart       = true;
        $this->showFeedback = true;

        // Dispatch event untuk update cart badge di navbar
        $this->dispatch('cart-updated');

        // Sembunyikan feedback setelah 2 detik
        $this->js("setTimeout(() => \$wire.hideFeedback(), 2000)");
    }

    public function hideFeedback(): void
    {
        $this->showFeedback = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}