{{-- resources/views/livewire/admin/book-table.blade.php --}}
<div>
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        {{-- Toolbar --}}
        <div class="p-5 flex flex-wrap items-center justify-between gap-3 border-b border-gray-100">
            <div class="flex gap-3 flex-wrap">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari judul, penulis..."
                    class="w-56 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <select wire:model.live="filterCategory"
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <button wire:click="openCreate"
                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                + Tambah Buku
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Buku</th>
                        <th class="px-5 py-3 text-left">Kategori</th>
                        <th class="px-5 py-3 text-right">Harga</th>
                        <th class="px-5 py-3 text-center">Stok</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}"
                                            class="w-10 h-14 object-cover rounded" alt="{{ $book->title }}">
                                    @else
                                        <div class="w-10 h-14 bg-gray-100 rounded flex items-center justify-center text-gray-300 text-xs">
                                            No img
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $book->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $book->category->name }}</td>
                            <td class="px-5 py-3 text-right text-gray-700">{{ $book->formattedPrice() }}</td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <button wire:click="openEdit({{ $book->id }})"
                                    class="text-blue-600 hover:underline text-xs">Edit</button>
                                <button wire:click="delete({{ $book->id }})"
                                    wire:confirm="Yakin ingin menghapus buku ini?"
                                    class="text-red-500 hover:underline text-xs">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Tidak ada buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $books->links() }}</div>
    </div>

    {{-- Modal Add/Edit Buku --}}
    @if ($showModal)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-5">
                {{ $editingId ? 'Edit Buku' : 'Tambah Buku' }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-600 mb-1">Judul Buku</label>
                    <input wire:model="title" type="text"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                    <select wire:model="category_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Penulis</label>
                    <input wire:model="author" type="text"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('author') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Penerbit</label>
                    <input wire:model="publisher" type="text"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Tahun terbit --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Tahun Terbit</label>
                    <input wire:model="published_year" type="number" min="1900" max="{{ date('Y') }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Harga (Rp)</label>
                    <input wire:model="price" type="number" min="0"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Stok</label>
                    <input wire:model="stock" type="number" min="0"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Cover image --}}
                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-600 mb-1">Cover Buku</label>
                    @if ($existingCover)
                        <img src="{{ Storage::url($existingCover) }}" class="h-24 rounded mb-2" alt="Cover saat ini">
                        <p class="text-xs text-gray-400 mb-2">Upload baru untuk mengganti cover.</p>
                    @endif
                    <input wire:model="cover_image" type="file" accept="image/*"
                        class="w-full text-sm text-gray-600">
                    @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-600 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="closeModal" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                    {{ $editingId ? 'Simpan Perubahan' : 'Tambah Buku' }}
                </button>
            </div>
        </div>
    </div>
    @endif
</div>