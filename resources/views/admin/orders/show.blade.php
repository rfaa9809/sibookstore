<x-admin-layout>
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Pesanan
            </h2>
            <a href="{{ route('admin.orders.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700">
                ← Kembali ke Daftar
            </a>
        </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if (session('success'))
            <div class="p-3 bg-green-50 text-green-700 rounded-lg text-sm"> {{ session('success') }}</div>
        @endif

        {{-- Header Order --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Nomor Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1 font-mono">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                        &middot; {{ $order->user->name }} ({{ $order->user->email }})
                    </p>
                </div>

                {{-- Badge status --}}
                <span class="self-start sm:self-center px-4 py-2 rounded-full text-sm font-semibold
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                      ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                      ($order->status === 'shipped'   ? 'bg-purple-100 text-purple-700' :
                      ($order->status === 'verified'  ? 'bg-indigo-100 text-indigo-700' :
                      ($order->status === 'paid'      ? 'bg-blue-100 text-blue-700' :
                      'bg-yellow-100 text-yellow-700')))) }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>

            {{-- Progress bar --}}
            @php
                $steps = ['pending' => 1, 'paid' => 2, 'verified' => 3, 'shipped' => 4, 'completed' => 5];
                $currentStep = $steps[$order->status] ?? 1;
            @endphp
            @if ($order->status !== 'cancelled')
                <div class="mt-6">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-2">
                        @foreach (['Menunggu Bayar', 'Bukti Dikirim', 'Terverifikasi', 'Dikirim', 'Selesai'] as $i => $label)
                            <span class="{{ $currentStep >= $i + 1 ? 'text-blue-600 font-semibold' : '' }}">
                                {{ $label }}
                            </span>
                        @endforeach
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full transition-all duration-500"
                            style="width: {{ ($currentStep / 5) * 100 }}%"></div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Alamat Pengiriman --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">📍 Alamat Pengiriman</h3>
                <p class="text-sm font-semibold text-gray-800">{{ $order->recipient_name }}</p>
                <p class="text-sm text-gray-500">{{ $order->recipient_phone }}</p>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $order->shipping_address }}</p>
                @if ($order->notes)
                    <p class="text-xs text-gray-400 mt-2 italic">Catatan: {{ $order->notes }}</p>
                @endif
            </div>

            {{-- Info Pembayaran --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">💳 Pembayaran</h3>
                @if ($order->payment)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-medium text-gray-800">{{ $order->payment->methodLabel() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah</span>
                            <span class="font-bold text-blue-600">{{ $order->payment->formattedAmount() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            <span class="font-medium
                                {{ $order->payment->status === 'verified' ? 'text-green-600' :
                                  ($order->payment->status === 'rejected' ? 'text-red-500' :
                                  ($order->payment->status === 'uploaded' ? 'text-blue-600' :
                                  'text-yellow-600')) }}">
                                {{ $order->payment->statusLabel() }}
                            </span>
                        </div>
                        @if ($order->payment->paid_at)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Diverifikasi</span>
                                <span class="text-gray-700">{{ $order->payment->paid_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Bukti Pembayaran --}}
                    @if ($order->payment->payment_proof)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2 font-medium">Bukti Pembayaran:</p>
                            <a href="{{ Storage::url($order->payment->payment_proof) }}" target="_blank">
                                <img src="{{ Storage::url($order->payment->payment_proof) }}"
                                    alt="Bukti Pembayaran"
                                    class="w-full max-h-52 object-cover rounded-lg border border-gray-200 hover:opacity-90 transition">
                            </a>
                        </div>
                    @endif

                    {{-- Catatan tolak --}}
                    @if ($order->payment->isRejected() && $order->payment->notes)
                        <div class="mt-3 p-3 bg-red-50 rounded-lg">
                            <p class="text-xs font-semibold text-red-600 mb-1">Alasan Penolakan:</p>
                            <p class="text-xs text-red-500">{{ $order->payment->notes }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-400">Belum ada data pembayaran.</p>
                @endif
            </div>
        </div>

        {{-- Daftar Buku --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-5">📦 Buku yang Dipesan</h3>
            <div class="space-y-4">
                @foreach ($order->orderItems as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-16 flex-shrink-0 rounded overflow-hidden bg-gray-50 border border-gray-100">
                            @if ($item->book->cover_image)
                                <img src="{{ Storage::url($item->book->cover_image) }}"
                                    class="w-full h-full object-cover" alt="{{ $item->book->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">
                                    No img
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->book->title }}</p>
                            <p class="text-xs text-gray-500">{{ $item->book->author }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $item->formattedPrice() }} × {{ $item->quantity }}
                            </p>
                        </div>
                        <p class="text-sm font-bold text-gray-700 flex-shrink-0">
                            Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 mt-5 pt-4 flex justify-between font-bold text-gray-800">
                <span>Total Pesanan</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Update Status --}}
        @if (!in_array($order->status, ['completed', 'cancelled']))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">🔄 Update Status Pesanan</h3>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-wrap gap-3 items-end">
                        <div class="flex-1 min-w-48">
                            <label class="block text-sm text-gray-600 mb-1">Ubah status menjadi</label>
                            <select name="status"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @if ($order->status === 'verified')
                                    <option value="shipped">Sedang Dikirim</option>
                                @endif
                                @if (in_array($order->status, ['verified', 'shipped']))
                                    <option value="completed">Selesai</option>
                                @endif
                                @if (!in_array($order->status, ['shipped', 'completed']))
                                    <option value="cancelled">Batalkan Pesanan</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit"
                            onclick="return confirm('Yakin ingin mengubah status pesanan ini?')"
                            class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                            Simpan Status
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</x-admin-layout>