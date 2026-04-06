<div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border">

        {{-- Toolbar --}}
        <div class="p-5 flex justify-between">
            <input wire:model.live.debounce.300ms="search"
                   placeholder="Cari user..."
                   class="text-sm border rounded-lg px-3 py-2">

            <select wire:model.live="role"
                    class="text-sm border rounded-lg px-3 py-2">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        {{-- Table --}}
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-center">Role</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>

                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $user->role === 'admin'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-gray-100 text-gray-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right">
                            <button wire:click="delete({{ $user->id }})"
                                    class="text-red-500 text-xs">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            Tidak ada user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $users->links() }}
        </div>

    </div>
</div>