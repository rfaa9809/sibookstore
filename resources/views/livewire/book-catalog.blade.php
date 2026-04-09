{{-- resources/views/livewire/book-catalog.blade.php --}}
<div>
    {{-- Toolbar: search + filter + sort --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <input wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Cari judul, penulis, penerbit..."
            class="flex-1 min-w-48 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

        <select wire:model.live="category"
            class="border border-gray-200 rounded-xl px-6 py-4.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->books_count ?? '' }})</option>
            @endforeach
        </select>

        <select wire:model.live="sortBy"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="latest">Terbaru</option>
            <option value="price_asc">Harga: Termurah</option>
            <option value="price_desc">Harga: Termahal</option>
            <option value="title_asc">Judul: A–Z</option>
        </select>
    </div>

    {{-- Loading state --}}
    <div wire:loading class="py-6 text-sm text-center text-gray-400">
        Memuat buku...
    </div>

    {{-- Grid buku --}}
    <div wire:loading.remove>
        @if ($books->isEmpty())
            <div class="py-20 text-center">
                <p class="mb-3 text-4xl">🔍</p>
                <p class="text-gray-500">Tidak ada buku yang ditemukan.</p>
                <button wire:click="$set('search', '')" class="mt-3 text-sm text-blue-600 hover:underline">
                    Reset pencarian
                </button>
            </div>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-6">
            @foreach ($books as $book)
                <div class="flex flex-col overflow-hidden transition bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md group">

                    {{-- LINK AREA --}}
                    <a href="{{ route('books.show', $book->slug) }}" class="block">
                        
                        {{-- Cover --}}
                        <div class="relative aspect-[2/3] bg-gray-50">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}"
                                    alt="{{ $book->title }}"
                                    class="object-cover w-full h-full transition group-hover:scale-105">
                            @else
                                <div class="flex items-center justify-center w-full h-full text-xs text-gray-300">
                                    No Cover
                                </div>
                            @endif

                            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ $book->category->name }}
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="p-3 space-y-1">
                            <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                {{ $book->title }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $book->author }}</p>
                            <p class="text-sm font-bold text-blue-600">{{ $book->formattedPrice() }}</p>

                            <p class="text-xs {{ $book->stock == 0 ? 'text-red-500' : 'text-green-600' }}">
                                {{ $book->stock == 0 ? 'Stok habis' : ($book->stock <= 5 ? 'Stok tersedia' : 'Sisa ' . $book->stock) }}
                            </p>    
                        </div>

                    </a>

                    {{-- ADD TO CART (di DALAM card, tapi di luar link) --}}
                    <div class="px-3 pb-3 mt-auto">
                        @livewire('add-to-cart', ['bookId' => $book->id], key('cart-'.$book->id))
                    </div>

                </div>
            @endforeach
        </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>