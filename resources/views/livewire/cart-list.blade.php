<div>
    @if ($items->isEmpty())
        <div class="py-24 text-center">
            <p class="mb-4 text-6xl">🛒</p>
            <p class="mb-2 text-lg text-gray-500">Keranjangmu masih kosong.</p>
            <p class="mb-6 text-sm text-gray-400">Yuk, mulai belanja buku favoritmu!</p>
            <a href="{{ route('home') }}"
               class="inline-block px-6 py-3 text-sm font-semibold text-white transition bg-blue-600 rounded-xl hover:bg-blue-700">
                Lihat Koleksi Buku
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
 
            {{-- Daftar item --}}
            <div class="space-y-4 lg:col-span-2">
                @foreach ($items as $item)
                    <div class="flex gap-4 p-4 bg-white border border-gray-100 shadow-sm rounded-xl">
                        {{-- Cover --}}
                        <div class="flex-shrink-0 w-16 h-24 overflow-hidden rounded bg-gray-50">
                            @if ($item->book->cover_image)
                                <img src="{{ Storage::url($item->book->cover_image) }}"
                                    alt="{{ $item->book->title }}"
                                    class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center w-full h-full text-xs text-gray-300">
                                    No Cover
                                </div>
                            @endif
                        </div>
 
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold leading-tight text-gray-800 truncate">{{ $item->book->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $item->book->author }}</p>
                            <p class="text-xs text-gray-400">{{ $item->book->category->name }}</p>
                            <p class="mt-2 text-sm font-bold text-blue-600">{{ $item->book->formattedPrice() }}</p>
                        </div>
 
                        {{-- Qty + Remove --}}
                        <div class="flex flex-col items-end justify-between flex-shrink-0">
                            <button wire:click="remove({{ $item->id }})"
                                wire:confirm="Hapus buku ini dari cart?"
                                class="text-lg leading-none text-gray-300 transition hover:text-red-400">
                                &times;
                            </button>
 
                            <div class="flex items-center gap-2 mt-3">
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                    class="text-sm text-gray-500 transition border border-gray-200 rounded-lg w-7 h-7 hover:bg-gray-50">
                                    &minus;
                                </button>
                                <span class="w-6 text-sm font-medium text-center text-gray-800">{{ $item->quantity }}</span>
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                    class="text-sm text-gray-500 transition border border-gray-200 rounded-lg w-7 h-7 hover:bg-gray-50">
                                    &#43;
                                </button>
                            </div>
 
                            <p class="mt-2 text-sm font-semibold text-gray-700">
                                Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
 
                {{-- Clear cart --}}
                <div class="text-right">
                    <button wire:click="clearCart"
                        wire:confirm="Hapus semua item dari cart?"
                        class="text-sm text-red-400 hover:text-red-600 hover:underline">
                        Hapus semua
                    </button>
                </div>
            </div>
 
            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="sticky p-6 bg-white border border-gray-100 shadow-sm rounded-xl top-6">
                    <h3 class="mb-5 font-semibold text-gray-800">Ringkasan Pesanan</h3>
 
                    <div class="space-y-3 text-sm text-gray-600">
                        @foreach ($items as $item)
                            <div class="flex justify-between">
                                <span class="truncate max-w-36">{{ $item->book->title }}</span>
                                <span>× {{ $item->quantity }}</span>
                            </div>
                        @endforeach
                    </div>
 
                    <div class="flex justify-between pt-4 mt-4 font-bold text-gray-800 border-t border-gray-100">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
 
                    <a href="{{ route('checkout.index') }}"
                       class="block w-full py-3 mt-5 text-sm font-semibold text-center text-white transition bg-blue-600 rounded-xl hover:bg-blue-700">
                        Lanjut ke Checkout
                    </a>
 
                    <a href="{{ route('home') }}"
                       class="mt-3 block w-full py-2.5 border border-gray-200 text-gray-600 text-sm text-center rounded-xl hover:bg-gray-50 transition">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>