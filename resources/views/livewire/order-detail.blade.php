{{-- resources/views/livewire/order-detail.blade.php --}}
<div class="space-y-6">
    @php
        $isCOD = $order->payment && $order->payment->method === 'cod';
    @endphp


    @if (session('success'))
        <div class="flex items-center gap-2 p-4 text-sm text-green-700 bg-green-50 rounded-xl">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Header status --}}
    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-medium tracking-wide text-gray-400 uppercase">Nomor Pesanan</p>
                <p class="mt-1 text-xl font-bold text-gray-800">{{ $order->order_number }}</p>
                <p class="mt-1 text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <span class="self-start sm:self-center px-4 py-2 rounded-full text-sm font-semibold
                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                  ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                  ($order->status === 'shipped'   ? 'bg-purple-100 text-purple-700' :
                  ($order->status === 'verified'  ? 'bg-indigo-100 text-indigo-700' :
                  ($order->status === 'paid'      ? 'bg-blue-100 text-blue-700' :
                  'bg-yellow-100 text-yellow-700')))) }}">
                @if ($isCOD)
                    @if ($order->status === 'shipped')
                        Pesanan Dikirim (COD)
                    @elseif ($order->status === 'completed')
                        Selesai (COD)
                    @else
                        {{ $order->statusLabel() }}
                    @endif
                @else
                    {{ $order->statusLabel() }}
                @endif
            </span>
        </div>

        {{-- Progress bar status --}}
        @php

            if ($isCOD) {
                $steps = [
                    'shipped'   => 1,
                    'completed' => 2,
                ];

                $labels = ['Dikirim', 'Selesai'];
                $maxStep = 2;
            } else {
                $steps = [
                    'pending'   => 1,
                    'paid'      => 2,
                    'verified'  => 3,
                    'shipped'   => 4,
                    'completed' => 5,
                ];

                $labels = ['Menunggu Bayar', 'Bukti Dikirim', 'Terverifikasi', 'Dikirim', 'Selesai'];
                $maxStep = 5;
            }

            $currentStep = $steps[$order->status] ?? 1;
        @endphp
        
        @if ($order->status !== 'cancelled')
            <div class="mt-6">
                <div class="flex items-center justify-between mb-2 text-xs text-gray-400">
                    @foreach ($labels as $i => $label)
                        <span class="{{ $currentStep >= $i + 1 ? 'text-blue-600 font-semibold' : '' }}">
                            {{ $label }}
                        </span>
                    @endforeach
                </div>

                <div class="h-2 overflow-hidden bg-gray-100 rounded-full">
                    <div class="h-full transition-all duration-500 bg-blue-600 rounded-full"
                        style="width: {{ ($currentStep / $maxStep) * 100 }}%">
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Alamat Pengiriman --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <h3 class="mb-4 font-semibold text-gray-800">Alamat Pengiriman</h3>
            <p class="text-sm font-medium text-gray-800">{{ $order->recipient_name }}</p>
            <p class="text-sm text-gray-500">{{ $order->recipient_phone }}</p>
            <p class="mt-2 text-sm leading-relaxed text-gray-500">{{ $order->shipping_address }}</p>
            @if ($order->notes)
                <p class="mt-2 text-xs italic text-gray-400">Catatan: {{ $order->notes }}</p>
            @endif
        </div>

        {{-- Info Pembayaran --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <h3 class="mb-4 font-semibold text-gray-800">Informasi Pembayaran</h3>

            @if ($order->payment)
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Metode</span>
                        <span class="font-medium text-gray-800">{{ $order->payment->methodLabel() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total</span>
                        <span class="font-bold text-blue-600">{{ $order->payment->formattedAmount() }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        <span class="font-medium
                            {{ $order->payment->status === 'verified' ? 'text-green-600' :
                              ($order->payment->status === 'rejected' ? 'text-red-500' :
                              ($order->payment->status === 'uploaded' ? 'text-blue-600' : 'text-yellow-600')) }}">
                            @if ($order->payment->method === 'cod')
                                <span class="italic text-gray-400">(Bayar di Tempat)</span>
                            @else
                                <span class="font-medium"> {{ $order->payment->statusLabel() }}</span>
                                    
                            @endif  
                        </span>
                    </div>
                </div>

                {{-- Bukti bayar sudah diupload --}}
                @if ($order->payment->payment_proof)
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <p class="mb-2 text-xs text-gray-500">Bukti Pembayaran:</p>
                        <a href="{{ Storage::url($order->payment->payment_proof) }}" target="_blank">
                            <img src="{{ Storage::url($order->payment->payment_proof) }}"
                                class="object-cover w-full transition border border-gray-200 rounded-lg max-h-48 hover:opacity-90"
                                alt="Bukti Pembayaran">
                        </a>
                    </div>
                @endif

                {{-- Notif jika ditolak --}}
                @if ($order->payment->isRejected())
                    <div class="p-3 mt-4 border border-red-100 bg-red-50 rounded-xl">
                        <p class="mb-1 text-xs font-semibold text-red-600">Pembayaran Ditolak</p>
                        <p class="text-xs text-red-500">{{ $order->payment->notes }}</p>
                    </div>
                @endif

                {{-- Upload bukti bayar --}}
                @if (in_array($order->payment->status, ['pending', 'rejected']) && $order->status !== 'cancelled' && $order->payment->method !== 'cod')
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        @if (! $showUploadForm)
                            @if(!in_array($order->payment->method, ['transfer', 'virtual_account']))
                                <button wire:click="$set('showUploadForm', true)"
                                    class="w-full py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                                    {{ $order->payment->isRejected() ? 'Upload Ulang Bukti' : 'Upload Bukti Pembayaran' }}
                                </button>
                            @endif
                            {{-- Info rekening untuk transfer --}}
                            @if ($order->payment->method === 'transfer')
                                <div class="p-3 mt-3 space-y-1 text-xs text-blue-700 bg-blue-50 rounded-xl">
                                    <p class="font-semibold">Transfer ke:</p>
                                    <p>BCA · 1234567890 · a/n BookStore Indonesia</p>
                                    <p>BRI · 0987654321 · a/n BookStore Indonesia</p>
                                </div>
                            @elseif ($order->payment->method === 'virtual_account')
                                <div class="p-3 mt-3 text-xs text-blue-700 bg-blue-50 rounded-xl">
                                    <p class="font-semibold">Kode Virtual Account:</p>
                                    <p class="mt-1 font-mono text-lg font-bold tracking-widest">
                                        {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            @endif
                        @else
                            {{-- <div class="space-y-3">
                                {{-- p class="text-sm font-medium text-gray-700">Upload Bukti Pembayaran</p>< --}}
                                {{-- <input wire:model="paymentProof" type="file" accept="image/*"
                                    class="w-full px-3 py-2 text-sm text-gray-600 border border-gray-200 rounded-xl">
                                @error('paymentProof') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                                @if ($paymentProof)
                                    <img src="{{ $paymentProof->temporaryUrl() }}"
                                        class="object-cover w-full rounded-lg max-h-40" alt="Preview">
                                @endif --}}

                                {{-- <div class="flex gap-2">
                                    <button wire:click="$set('showUploadForm', false)"
                                        class="flex-1 py-2 text-sm text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50">
                                        Batal
                                    </button>
                                    <button wire:click="uploadProof"
                                        wire:loading.attr="disabled"
                                        class="flex-1 py-2 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 disabled:opacity-60">
                                        <span wire:loading.remove wire:target="uploadProof">Kirim</span>
                                        <span wire:loading wire:target="uploadProof">Mengirim...</span>
                                    </button>
                                </div>
                            </div> --}}
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Daftar Buku --}}
    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
        <h3 class="mb-5 font-semibold text-gray-800">Buku yang Dipesan</h3>
        <div class="space-y-4">
            @foreach ($order->orderItems as $item)
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-16 overflow-hidden rounded bg-gray-50">
                        @if ($item->book->cover_image)
                            <img src="{{ Storage::url($item->book->cover_image) }}"
                                class="object-cover w-full h-full" alt="{{ $item->book->title }}">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->book->title }}</p>
                        <p class="text-xs text-gray-500">{{ $item->book->author }}</p>
                        <p class="text-xs text-gray-400">{{ $item->formattedPrice() }} × {{ $item->quantity }}</p>
                    </div>
                    <p class="flex-shrink-0 text-sm font-bold text-gray-700">
                        Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between pt-4 mt-5 font-bold text-gray-800 border-t border-gray-100">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="flex justify-between gap-3">
        <a href="{{ route('home') }}"
           class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm rounded-xl hover:bg-gray-50 transition">
            Lanjut Belanja
        </a>

        @if ($order->status === 'pending')
            <button 
                wire:click="cancelOrder"
                class="px-4 py-2 mt-4 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                Batalkan Pesanan
            </button>
        @endif
    </div>
</div>