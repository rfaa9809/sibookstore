<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $cards = [
                    ['label' => 'Total Buku',     'value' => $stats['total_books'],      'color' => 'blue'],
                    ['label' => 'Total User',     'value' => $stats['total_users'],      'color' => 'indigo'],
                    ['label' => 'Total Order',    'value' => $stats['total_orders'],     'color' => 'purple'],
                    ['label' => 'Butuh Verifikasi','value'=> $stats['pending_payments'], 'color' => 'yellow'],
                    ['label' => 'Pesan Masuk',    'value' => $stats['unread_messages'],  'color' => 'pink'],
                    ['label' => 'Total Revenue',  'value' => 'Rp '.number_format($stats['revenue'],0,',','.'), 'color' => 'green'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Recent Orders --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-700">Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($recentOrders as $order)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->name }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                                  ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                                  ($order->status === 'verified'  ? 'bg-indigo-100 text-indigo-700' :
                                  'bg-yellow-100 text-yellow-700')) }}">
                                {{ $order->statusLabel() }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 text-center">Belum ada pesanan.</p>
                    @endforelse
                </div>
            </div>

            {{-- Pending Payments --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-700">Menunggu Verifikasi</h3>
                    <a href="{{ route('admin.payments.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($pendingPayments as $payment)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $payment->order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->order->user->name }} &middot; {{ $payment->methodLabel() }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ $payment->formattedAmount() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 py-4 text-center">Tidak ada pembayaran yang menunggu verifikasi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>