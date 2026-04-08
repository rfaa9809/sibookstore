<x-app-layout>
    <div class="max-w-5xl px-4 py-10 mx-auto">

        <h1 class="mb-6 text-xl font-bold">Pesanan Saya</h1>

        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order->id) }}"
            class="block p-4 mb-3 bg-white border rounded-lg hover:shadow">

                <div class="flex justify-between">
                    <img src="{{ optional($order->orderItems->first()?->book?->cover_image) ? Storage::url($order->orderItems->first()->book->cover_image) : asset('images/no-cover.png') }}"
                        alt="Cover"
                        class="object-cover w-12 h-16 rounded">
                    
                    <span class="flex-1 mx-4 text-sm font-medium text-gray-800">
                        {{ optional($order->orderItems->first()?->book)->title ?? 'Buku tidak ditemukan' }}
                    </span>

                    <span class="text-sm text-gray-500">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="mt-1 text-sm text-gray-500">
                    Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </p>
            </a>
        @empty
            <p class="text-gray-500">Belum ada pesanan.</p>
        @endforelse

    </div>
</x-app-layout>