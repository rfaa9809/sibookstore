{{-- resources/views/livewire/admin/order-table.blade.php --}}
<div>

    <div class="bg-white rounded-xl shadow-sm border">

        {{-- Header --}}
        <div class="p-5 border-b flex justify-between">
            <input wire:model.live.debounce.300ms="search"
                   placeholder="Cari order..."
                   class="text-sm border rounded-lg px-3 py-2">

            <select wire:model.live="status"
                    class="text-sm border rounded-lg px-3 py-2">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="verified">Verified</option>
                <option value="shipped">Shipped</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        {{-- Table --}}
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Order</th>
                    <th class="px-5 py-3 text-left">User</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-right">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            {{ $order->order_number }}
                        </td>

                        <td class="px-5 py-3">
                            {{ $order->user->name }}
                        </td>

                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                   'bg-blue-100 text-blue-700') }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right">
                            {{ $order->formattedTotal() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            Tidak ada order
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $orders->links() }}
        </div>

    </div>
</div>