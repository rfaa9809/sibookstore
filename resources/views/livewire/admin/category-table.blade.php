{{-- resources/views/livewire/admin/category-table.blade.php --}}
<div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- Toolbar --}}
        <div class="p-5 flex justify-between items-center border-b">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Cari kategori..."
                   class="text-sm border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">

            <button wire:click="openCreate"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">
                + Tambah Kategori
            </button>
        </div>

        {{-- Table --}}
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($categories as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">{{ $cat->name }}</td>
                        <td class="px-5 py-3 text-right">
                            <button wire:click="openEdit({{ $cat->id }})"
                                    class="text-blue-600 text-xs">Edit</button>

                            <button wire:click="delete({{ $cat->id }})"
                                    class="text-red-500 text-xs ml-2">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-6 text-gray-400">
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
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">

                <h3 class="font-semibold mb-4">
                    {{ $editingId ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h3>

                <input wire:model="name"
                       class="w-full border rounded-lg px-3 py-2 text-sm">

                @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

                <div class="flex justify-end gap-3 mt-4">
                    <button wire:click="closeModal">Batal</button>
                    <button wire:click="save"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>