<x-admin-layout>
    <div class="max-w-5xl px-4 py-10 mx-auto">

        <h1 class="mb-6 text-xl font-bold">Pesan Masuk</h1>

        @forelse ($messages as $msg)
            <div class="p-4 mb-3 bg-white border rounded-lg">

                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">
                            {{ $msg->user->name ?? 'Guest' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $msg->user->email }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $msg->subject }}
                        </p>
                    </div>

                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" 
                        method="POST"
                        onsubmit="return confirm('Yakin mau hapus pesan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-sm text-red-600 hover:underline">
                            Hapus
                        </button>
                    </form>

                    @if (!$msg->is_read)
                        <form method="POST" action="{{ route('admin.messages.read', $msg->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="text-xs text-blue-600">
                                Tandai dibaca
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-green-600">✓ Dibaca</span>
                    @endif
                </div>

                <p class="mt-3 text-sm text-gray-700">
                    {{ $msg->message }}
                </p>

            </div>
        @empty
            <p class="text-gray-500">Belum ada pesan.</p>
        @endforelse

    </div>
</x-admin-layout>