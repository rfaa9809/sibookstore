<x-app-layout>
    <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8 py-14">

        <div class="mb-10 text-center">
            <h1 class="mb-3 text-4xl font-bold text-gray-800">Hubungi Kami</h1>
            <p class="text-gray-500">Ada pertanyaan atau kendala? Kami siap membantu.</p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">

            {{-- Info Kontak --}}
            <div class="space-y-5">
                @foreach ([
                    ['icon' => '📧', 'label' => 'Email',    'value' => 'hello@bookstore.com'],
                    ['icon' => '📞', 'label' => 'Telepon',  'value' => '+62 812-3456-7890'],
                    ['icon' => '🕒', 'label' => 'Jam Kerja','value' => 'Sen–Jum, 09.00–17.00 WIB'],
                    ['icon' => '📍', 'label' => 'Alamat',   'value' => 'Jl. Buku Indah No.1, Jakarta'],
                ] as $info)
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">{{ $info['icon'] }}</span>
                        <div>
                            <p class="text-xs font-medium tracking-wide text-gray-400 uppercase">{{ $info['label'] }}</p>
                            <p class="text-gray-700 text-sm mt-0.5">{{ $info['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Form --}}
            <div class="p-8 bg-white border border-gray-100 shadow-sm md:col-span-2 rounded-2xl">

                @if (session('success'))
                    <div class="flex items-center gap-2 p-4 mb-5 text-sm text-green-700 bg-green-50 rounded-xl">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif

                @if (! auth()->check())
                    <div class="p-4 mb-5 text-sm text-yellow-700 bg-yellow-50 rounded-xl">
                        Kamu harus <a href="{{ route('login') }}" class="font-medium underline">login</a> terlebih dahulu untuk mengirim pesan.
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama & Email otomatis jika sudah login --}}
                    @auth
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-sm text-gray-600">Nama</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled
                                    class="w-full px-3 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg bg-gray-50">
                            </div>
                            <div>
                                <label class="block mb-1 text-sm text-gray-600">Email</label>
                                <input type="text" value="{{ auth()->user()->email }}" disabled
                                    class="w-full px-3 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg bg-gray-50">
                            </div>
                        </div>
                    @endauth

                    <div>
                        <label for="subject" class="block mb-1 text-sm text-gray-600">Subjek</label>
                        <input id="subject" name="subject" type="text"
                            value="{{ old('subject') }}"
                            placeholder="Contoh: Pertanyaan tentang pesanan"
                            {{ ! auth()->check() ? 'disabled' : '' }}
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50">
                        @error('subject') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block mb-1 text-sm text-gray-600">Pesan</label>
                        <textarea id="message" name="message" rows="5"
                            placeholder="Tuliskan pesanmu di sini..."
                            {{ ! auth()->check() ? 'disabled' : '' }}
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        {{ ! auth()->check() ? 'disabled' : '' }}
                        class="w-full py-3 text-sm font-semibold text-white transition bg-blue-600 rounded-xl hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>