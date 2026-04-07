{{-- resources/views/livewire/add-to-cart.blade.php --}}
<div>
    @if ($showFeedback)
        <div class="w-full py-2 text-xs font-medium text-center text-white transition bg-green-500 rounded-lg">
            ✓ Ditambahkan ke cart!
        </div>
    @elseif ($inCart)
        <div class="flex gap-2">
            <a href="{{ route('cart.index') }}"
               class="flex-1 py-2 text-xs font-medium text-center text-blue-600 transition border border-blue-600 rounded-lg hover:bg-blue-50">
                Lihat Cart
            </a>
            <button wire:click="addToCart"
                class="flex-1 py-2 text-xs font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah
            </button>
        </div>
    @else
        <button wire:click="addToCart"
            wire:loading.attr="disabled"
            class="w-full py-2 text-xs font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 disabled:opacity-60">
            <span wire:loading.remove wire:target="addToCart">Tambah ke Cart</span>
            <span wire:loading wire:target="addToCart">Menambahkan...</span>
        </button>
    @endif
</div>