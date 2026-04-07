<x-app-layout>
    <div class="max-w-6xl px-4 py-10 mx-auto sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 mb-8 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('home') }}#catalog" class="hover:text-blue-600">{{ $book->category->name }}</a>
            <span>/</span>
            <span class="text-gray-600 truncate max-w-48">{{ $book->title }}</span>
        </nav>

        {{-- Detail Buku --}}
        <div class="grid grid-cols-1 gap-10 mb-16 md:grid-cols-2">

            {{-- Cover --}}
            <div class="flex justify-center">
                <div class="w-full max-w-sm">
                    @if ($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}"
                            alt="{{ $book->title }}"
                            class="w-full rounded-2xl shadow-xl object-cover aspect-[2/3]">
                    @else
                        <div class="w-full aspect-[2/3] bg-gray-100 rounded-2xl flex items-center justify-center text-gray-300 text-lg">
                            No Cover
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="flex flex-col justify-center space-y-5">
                {{-- Kategori badge --}}
                <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full w-fit">
                    {{ $book->category->name }}
                </span>

                <h1 class="text-3xl font-bold leading-tight text-gray-800">{{ $book->title }}</h1>

                <div class="space-y-1 text-sm text-gray-500">
                    <p><span class="font-medium text-gray-700">Penulis:</span> {{ $book->author }}</p>
                    @if ($book->publisher)
                        <p><span class="font-medium text-gray-700">Penerbit:</span> {{ $book->publisher }}</p>
                    @endif
                    @if ($book->published_year)
                        <p><span class="font-medium text-gray-700">Tahun Terbit:</span> {{ $book->published_year }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <p class="text-3xl font-bold text-blue-600">{{ $book->formattedPrice() }}</p>
                    <span class="text-sm {{ $book->stock > 5 ? 'text-green-600 bg-green-50' : ($book->stock > 0 ? 'text-orange-500 bg-orange-50' : 'text-red-500 bg-red-50') }} px-3 py-1 rounded-full font-medium">
                        {{ $book->stock > 5 ? 'Stok Tersedia' : ($book->stock > 0 ? "Sisa {$book->stock}" : 'Stok Habis') }}
                    </span>
                </div>

                @if ($book->description)
                    <div class="pt-4 text-sm leading-relaxed text-gray-600 border-t border-gray-100">
                        <p class="mb-2 font-semibold text-gray-700">Deskripsi</p>
                        <p>{{ $book->description }}</p>
                    </div>
                @endif

                {{-- Add to Cart --}}
                @if ($book->isInStock())
                    <div class="pt-2">
                        @livewire('add-to-cart', ['bookId' => $book->id], key($book->id))
                    </div>
                @else
                    <button disabled class="w-full py-3 font-semibold text-gray-400 bg-gray-200 cursor-not-allowed rounded-xl">
                        Stok Habis
                    </button>
                @endif
            </div>
        </div>

        {{-- Buku Terkait --}}
        @if ($related->isNotEmpty())
            <div>
                <h2 class="mb-6 text-xl font-bold text-gray-800">Buku Lainnya dari Kategori Ini</h2>
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4">
                    @foreach ($related as $rel)
                        <a href="{{ route('books.show', $rel->slug) }}"
                           class="overflow-hidden transition bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md group">
                            <div class="aspect-[2/3] bg-gray-50">
                                @if ($rel->cover_image)
                                    <img src="{{ Storage::url($rel->cover_image) }}"
                                        alt="{{ $rel->title }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-xs text-gray-300">No Cover</div>
                                @endif
                            </div>
                            <div class="p-3 space-y-1">
                                <p class="text-sm font-semibold leading-tight text-gray-800 line-clamp-2">{{ $rel->title }}</p>
                                <p class="text-xs text-gray-500">{{ $rel->author }}</p>
                                <p class="text-sm font-bold text-blue-600">{{ $rel->formattedPrice() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>