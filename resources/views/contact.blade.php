<x-app-layout>
    <div class="max-w-5xl px-4 py-20 mx-auto sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="max-w-2xl mb-16">
            <h1 class="text-4xl font-light tracking-tight text-gray-900 md:text-5xl">
                Kami siap <span class="font-serif italic text-indigo-600">mendengar</span> Anda.
            </h1>
            <p class="mt-6 text-lg leading-relaxed text-gray-500">
                Punya pertanyaan mengenai koleksi kami atau butuh bantuan dengan pesanan? Tim kami akan merespons dalam waktu kurang dari 24 jam.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-16 lg:grid-cols-12">

            {{-- Contact Information --}}
            <div class="space-y-12 lg:col-span-4">
                <div class="space-y-8">
                    @foreach ([
                        ['label' => 'Surel', 'value' => 'hello@bookstore.com'],
                        ['label' => 'Telepon', 'value' => '+62 812 3456 7890'],
                        ['label' => 'Jam Operasional', 'value' => 'Senin – Jumat, 09:00 – 17:00 WIB'],
                        ['label' => 'Kantor Pusat', 'value' => 'Jl. Buku Indah No.1, Jakarta, Indonesia']
                    ] as $info)
                        <div class="group">
                            <p class="text-xs font-bold tracking-widest text-gray-400 uppercase">{{ $info['label'] }}</p>
                            <p class="mt-2 font-medium text-gray-700 transition-colors duration-300 group-hover:text-indigo-600">
                                {{ $info['value'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- Social Links - Subtle --}}
                <div class="pt-8 border-t border-gray-100">
                    <p class="mb-4 text-xs font-bold tracking-widest text-gray-400 uppercase">Ikuti Kami</p>
                    <div class="flex gap-4">
                        <span class="text-sm text-gray-500 cursor-pointer hover:text-indigo-600">Instagram</span>
                        <span class="text-sm text-gray-500 cursor-pointer hover:text-indigo-600">Twitter</span>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="lg:col-span-8">
                <div class="p-1 text-gray-900">
                    
                    @if (session('success'))
                        <div class="flex items-center gap-3 p-4 mb-8 text-sm text-indigo-700 border border-indigo-100 rounded-lg bg-indigo-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (! auth()->check())
                        <div class="p-4 mb-8 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                            Silakan <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk</a> untuk mulai mengirimkan pesan kepada kami.
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-xs font-bold tracking-widest text-gray-400 uppercase">Nama Lengkap</label>
                                <input type="text" value="{{ auth()->check() ? auth()->user()->name : '' }}" disabled
                                    class="w-full px-4 py-3 text-sm text-gray-500 border-none rounded-lg bg-gray-50 focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold tracking-widest text-gray-400 uppercase">Alamat Surel</label>
                                <input type="text" value="{{ auth()->check() ? auth()->user()->email : '' }}" disabled
                                    class="w-full px-4 py-3 text-sm text-gray-500 border-none rounded-lg bg-gray-50 focus:ring-0">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="subject" class="text-xs font-bold tracking-widest text-gray-400 uppercase">Subjek Pesan</label>
                            <input id="subject" name="subject" type="text"
                                value="{{ old('subject') }}"
                                placeholder="Apa yang ingin Anda bahas?"
                                {{ ! auth()->check() ? 'disabled' : '' }}
                                class="w-full px-0 py-3 text-gray-900 placeholder-gray-300 transition-colors bg-transparent border-t-0 border-b border-gray-200 border-x-0 focus:border-indigo-600 focus:ring-0">
                            @error('subject') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="text-xs font-bold tracking-widest text-gray-400 uppercase">Pesan Anda</label>
                            <textarea id="message" name="message" rows="4"
                                placeholder="Tuliskan detail pertanyaan Anda di sini..."
                                {{ ! auth()->check() ? 'disabled' : '' }}
                                class="w-full px-0 py-3 text-gray-900 placeholder-gray-300 transition-colors bg-transparent border-t-0 border-b border-gray-200 resize-none border-x-0 focus:border-indigo-600 focus:ring-0">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                {{ ! auth()->check() ? 'disabled' : '' }}
                                class="inline-flex items-center justify-center px-10 py-4 text-sm font-medium text-white transition-all bg-gray-900 rounded-lg shadow-lg hover:bg-indigo-600 disabled:opacity-30 shadow-gray-200">
                                Kirimkan Pesan
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>