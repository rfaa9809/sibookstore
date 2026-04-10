{{-- resources/views/livewire/admin/category-table.blade.php --}}
<div>

    @if(session('success'))
        <div class="p-4 mb-6 text-green-800 bg-green-100 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-6 text-red-800 bg-red-100 border border-red-200 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 shadow-sm rounded-xl">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between p-5 border-b">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Cari kategori..."
                   class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">

            <button wire:click="openCreate"
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">
                + Tambah Kategori
            </button>
        </div>

        {{-- Table --}}
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Deskripsi</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($categories as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">{{ $cat->name }}</td>
                        <td class="px-5 py-3">{{ $cat->description }}</td>
                        <td class="px-5 py-3 text-right">
                            <button wire:click="openEdit({{ $cat->id }})"
                                    class="text-xs text-blue-600">
                                    Edit
                            </button>
                                
                            <button wire:click="delete({{ $cat->id }})"
                                        wire:confirm="Yakin ingin menghapus Kategori ini?"
                                        class="ml-2 text-xs text-red-500">
                                    Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-6 text-center text-gray-400">
                            Tidak ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">{{ $categories->links() }}</div>
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40">
            <div class="w-full max-w-md p-6 bg-white rounded-xl">

                <h3 class="mb-4 font-semibold">
                    {{ $editingId ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h3>

                <input wire:model="name"
                       class="w-full px-3 py-2 text-sm border rounded-lg"
                       placeholder="Nama kategori...">

                @error('name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <textarea wire:model="description"
                          class="w-full px-3 py-2 mt-2 text-sm border rounded-lg"
                          placeholder="Deskripsi kategori..."></textarea>

                @error('description') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <div class="flex justify-end gap-3 mt-4">
                    <button wire:click="closeModal">Batal</button>
                    <button wire:click="save"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>