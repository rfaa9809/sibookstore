{{-- resources/views/livewire/admin/payment-table.blade.php --}}
<div>
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        {{-- Filter tabs --}}
        <div class="flex border-b border-gray-100 px-5 pt-4 gap-4">
            @foreach (['uploaded' => 'Perlu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak', '' => 'Semua'] as $val => $label)
                <button wire:click="$set('filterStatus', '{{ $val }}')"
                    class="pb-3 text-sm border-b-2 transition-colors
                        {{ $filterStatus === $val
                            ? 'border-blue-600 text-blue-600 font-medium'
                            : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Order</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Metode</th>
                        <th class="px-5 py-3 text-right">Jumlah</th>
                        <th class="px-5 py-3 text-center">Bukti</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $payment->order->order_number }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $payment->order->user->name }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $payment->methodLabel() }}
                            </td>
                            <td class="px-5 py-3 text-right font-medium text-gray-700">
                                {{ $payment->formattedAmount() }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if ($payment->payment_proof)
                                    <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank"
                                        class="text-blue-600 hover:underline text-xs">Lihat Bukti</a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    {{ $payment->status === 'verified' ? 'bg-green-100 text-green-700' :
                                      ($payment->status === 'rejected' ? 'bg-red-100 text-red-700' :
                                      ($payment->status === 'uploaded' ? 'bg-blue-100 text-blue-700' :
                                      'bg-yellow-100 text-yellow-700')) }}">
                                    {{ $payment->statusLabel() }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                @if ($payment->isUploaded())
                                    <button wire:click="verify({{ $payment->id }})"
                                        wire:confirm="Verifikasi pembayaran ini?"
                                        class="text-green-600 hover:underline text-xs font-medium">
                                        Verifikasi
                                    </button>
                                    <button wire:click="openReject({{ $payment->id }})"
                                        class="text-red-500 hover:underline text-xs">
                                        Tolak
                                    </button>
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">Tidak ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $payments->links() }}</div>
    </div>

    {{-- Modal Tolak Pembayaran --}}
    @if ($showRejectModal)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tolak Pembayaran</h3>
            <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan agar user tahu perlu upload ulang bukti yang valid.</p>

            <textarea wire:model="rejectNotes" rows="4" placeholder="Contoh: Bukti pembayaran tidak terbaca, nominal tidak sesuai..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
            @error('rejectNotes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <div class="flex justify-end gap-3 mt-4">
                <button wire:click="closeRejectModal" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                <button wire:click="confirmReject" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                    Konfirmasi Tolak
                </button>
            </div>
        </div>
    </div>
    @endif
</div>