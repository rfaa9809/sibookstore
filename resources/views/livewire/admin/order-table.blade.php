{{-- resources/views/livewire/admin/order-table.blade.php --}}
<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- Toolbar --}}
        <div class="p-5 flex flex-wrap items-center justify-between gap-3 border-b border-gray-100">
            <input wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Cari no. order atau nama user..."
                class="w-64 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select wire:model.live="filterStatus"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu Pembayaran</option>
                <option value="paid">Bukti Dikirim</option>
                <option value="verified">Terverifikasi</option>
                <option value="shipped">Sedang Dikirim</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">No. Order</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Tgl Order</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3 text-center">Pembayaran</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-mono text-xs font-semibold text-gray-700">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">
                                {{ $order->created_at->format('d M Y') }}<br>
                                <span class="text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-5 py-3 text-right font-semibold text-gray-700">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if ($order->payment)
                                    <span class="text-xs px-2 py-0.5 rounded-full
                                        {{ $order->payment->status === 'verified' ? 'bg-green-100 text-green-700' :
                                          ($order->payment->status === 'rejected' ? 'bg-red-100 text-red-700' :
                                          ($order->payment->status === 'uploaded' ? 'bg-blue-100 text-blue-700' :
                                          'bg-yellow-100 text-yellow-700')) }}">
                                        {{ $order->payment->statusLabel() }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-xs px-2 py-0.5 rounded-full
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                                      ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                                      ($order->status === 'shipped'   ? 'bg-purple-100 text-purple-700' :
                                      ($order->status === 'verified'  ? 'bg-indigo-100 text-indigo-700' :
                                      ($order->status === 'paid'      ? 'bg-blue-100 text-blue-700' :
                                      'bg-yellow-100 text-yellow-700')))) }}">
                                    {{ $order->statusLabel() }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="text-blue-600 hover:underline text-xs font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-400">
                                Tidak ada pesanan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">{{ $orders->links() }}</div>
    </div>
</div>