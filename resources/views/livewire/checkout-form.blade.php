{{-- resources/views/livewire/checkout-form.blade.php --}}
<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

    {{-- Form Area --}}
    <div class="lg:col-span-2">

        {{-- Step Indicator --}}
        <div class="flex items-center gap-2 mb-8">
            @foreach ([1 => 'Alamat', 2 => 'Pembayaran', 3 => 'Konfirmasi'] as $num => $label)
                <div class="flex items-center gap-2 {{ !$loop->last ? 'flex-1' : '' }}">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors
                            {{ $step >= $num ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                            {{ $step > $num ? '✓' : $num }}
                        </div>
                        <span class="text-sm font-medium {{ $step >= $num ? 'text-gray-800' : 'text-gray-400' }}">
                            {{ $label }}
                        </span>
                    </div>
                    @if (!$loop->last)
                        <div class="flex-1 h-0.5 {{ $step > $num ? 'bg-blue-600' : 'bg-gray-200' }} mx-2 rounded"></div>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($errors->has('stock'))
            <div class="p-3 mb-4 text-sm text-red-700 rounded-lg bg-red-50">{{ $errors->first('stock') }}</div>
        @endif

        {{-- ======================== STEP 1: Alamat ======================== --}}
        @if ($step === 1)
            <div class="p-6 space-y-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Pengiriman</h2>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block mb-1 text-sm text-gray-600">Nama Penerima <span class="text-red-500">*</span></label>
                        <input wire:model="recipientName" type="text"
                            placeholder="Nama lengkap penerima"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('recipientName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-sm text-gray-600">No. HP Penerima <span class="text-red-500">*</span></label>
                        <input wire:model="recipientPhone" type="text"
                            placeholder="08xxxxxxxxxx"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('recipientPhone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm text-gray-600">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <input wire:model="addressStreet" type="text"
                        placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('addressStreet') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block mb-1 text-sm text-gray-600">Kota <span class="text-red-500">*</span></label>
                        <input wire:model="addressCity" type="text"
                            placeholder="Kota / Kabupaten"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('addressCity') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-sm text-gray-600">Provinsi <span class="text-red-500">*</span></label>
                        <input wire:model="addressProvince" type="text"
                            placeholder="Provinsi"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('addressProvince') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-sm text-gray-600">Kode Pos <span class="text-red-500">*</span></label>
                        <input wire:model="addressPostal" type="text"
                            placeholder="12345"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('addressPostal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm text-gray-600">Catatan (opsional)</label>
                    <textarea wire:model="notes" rows="2"
                        placeholder="Contoh: Titip di satpam, pintu biru, dll."
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button wire:click="nextStep"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                        Lanjut ke Pembayaran →
                    </button>
                </div>
            </div>
        @endif

        {{-- ======================== STEP 2: Metode Pembayaran ======================== --}}
        @if ($step === 2)
            <div class="p-6 space-y-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <h2 class="text-lg font-semibold text-gray-800">Metode Pembayaran</h2>
                <p class="text-sm text-gray-500">Pilih metode pembayaran. Bukti pembayaran akan diupload setelah order dikonfirmasi.</p>

                <div class="space-y-3">
                    @foreach ([
                        'transfer'        => ['label' => 'Transfer Bank',     'desc' => 'BCA, BRI, BNI, Mandiri.', 'icon' => '🏦'],
                        'virtual_account' => ['label' => 'Virtual Account',   'desc' => 'Bayar via kode VA.',       'icon' => '💳'],
                        'cod'             => ['label' => 'Cash on Delivery',  'desc' => 'Bayar saat barang tiba.',  'icon' => '💵'],
                    ] as $value => $opt)

                        <div 
                            wire:click="$set('paymentMethod', '{{ $value }}')" 
                            class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer transition
                            {{ $paymentMethod === $value ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <input type="radio" value="{{ $value }}" class="hidden">

                            <span class="text-2xl">{{ $opt['icon'] }}</span>

                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ $opt['label'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $opt['desc'] }}</p>
                            </div>

                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                {{ $paymentMethod === $value ? 'border-blue-600' : 'border-gray-300' }}">
                                @if ($paymentMethod === $value)
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                                @endif
                            </div>
                        </div>

                    @endforeach
                </div>
                @error('paymentMethod') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <div class="flex justify-between pt-2">
                    <button wire:click="prevStep"
                        class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        ← Kembali
                    </button>
                    <button wire:click="nextStep"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                        Lihat Konfirmasi →
                    </button>
                </div>
            </div>
        @endif

        {{-- ======================== STEP 3: Konfirmasi ======================== --}}
        @if ($step === 3)
            <div class="space-y-4">
                {{-- Ringkasan Alamat --}}
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-800">Alamat Pengiriman</h3>
                        <button wire:click="$set('step', 1)" class="text-xs text-blue-600 hover:underline">Ubah</button>
                    </div>
                    <p class="text-sm font-medium text-gray-800">{{ $recipientName }} · {{ $recipientPhone }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $this->fullAddress() }}</p>
                    @if ($notes)
                        <p class="mt-1 text-xs italic text-gray-400">Catatan: {{ $notes }}</p>
                    @endif
                </div>

                {{-- Ringkasan Pembayaran --}}
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-800">Metode Pembayaran</h3>
                        <button wire:click="$set('step', 2)" class="text-xs text-blue-600 hover:underline">Ubah</button>
                    </div>
                    <p class="text-sm text-gray-700">
                        {{ ['transfer' => '🏦 Transfer Bank', 'virtual_account' => '💳 Virtual Account', 'cod' => '💵 Cash on Delivery'][$paymentMethod] ?? '-' }}
                    </p>
                </div>

                {{-- Ringkasan Item --}}
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <h3 class="mb-4 font-semibold text-gray-800">Buku yang Dipesan</h3>
                    <div class="space-y-3">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 overflow-hidden rounded h-14 bg-gray-50">
                                    @if ($item->book->cover_image)
                                        <img src="{{ Storage::url($item->book->cover_image) }}"
                                            class="object-cover w-full h-full" alt="{{ $item->book->title }}">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $item->book->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->book->formattedPrice() }} × {{ $item->quantity }}</p>
                                </div>
                                <p class="flex-shrink-0 text-sm font-semibold text-gray-700">
                                    Rp {{ number_format($item->subtotal(), 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between pt-2">
                    <button wire:click="prevStep"
                        class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        ← Kembali
                    </button>
                    <button wire:click="placeOrder"
                        wire:loading.attr="disabled"
                        class="px-8 py-2.5 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="placeOrder">✓ Buat Pesanan</span>
                        <span wire:loading wire:target="placeOrder">Memproses...</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- Order Summary Sidebar --}}
    <div class="lg:col-span-1">
        <div class="sticky p-6 bg-white border border-gray-100 shadow-sm rounded-2xl top-6">
            <h3 class="mb-5 font-semibold text-gray-800">Ringkasan</h3>

            <div class="space-y-3 overflow-y-auto text-sm text-gray-600 max-h-64">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between gap-2">
                        <span class="truncate">{{ $item->book->title }} <span class="text-gray-400">×{{ $item->quantity }}</span></span>
                        <span class="flex-shrink-0 font-medium">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 mt-4 space-y-2 text-sm border-t border-gray-100">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Ongkos Kirim</span>
                    <span class="font-medium text-green-600">Gratis</span>
                </div>
                <div class="flex justify-between pt-2 text-base font-bold text-gray-800 border-t border-gray-100">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>