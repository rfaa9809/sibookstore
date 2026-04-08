<x-app-layout>

    <section class="relative bg-center bg-cover border-b border-gray-100" style="background-image: url('{{ asset('assets/book_bg.png') }}')">
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative z-10 px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col items-center text-center">
                <span class="inline-block px-4 py-1.5 mb-6 text-xs font-medium tracking-wider text-indigo-600 uppercase bg-indigo-50 rounded-full">
                    Koleksi Buku Terpilih
                </span>
                <h1 class="max-w-3xl text-4xl font-light tracking-tight text-gray-900 md:text-6xl">
                    Temukan inspirasi dalam <span class="font-serif italic text-indigo-600">setiap lembar</span> buku.
                </h1>
                <p class="max-w-xl mt-6 text-lg leading-relaxed text-black-500">
                    Platform sederhana untuk mencari dan mengoleksi buku dari penulis favorit Anda. Tanpa ribet, langsung sampai.
                </p>
                <div class="flex flex-col gap-4 mt-10 sm:flex-row">
                    <a href="#catalog" 
                       class="px-8 py-4 text-sm font-medium text-white transition bg-gray-900 rounded-lg shadow-sm hover:bg-gray-800">
                        Mulai Menjelajah
                    </a>
                    <a href="{{ route('about') }}" 
                       class="px-8 py-4 text-sm font-medium text-gray-600 transition bg-transparent border border-gray-200 rounded-lg hover:bg-gray-50">
                        Tentang Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                @foreach ([
                    ['label' => 'Koleksi Judul', 'value' => '10k+'],
                    ['label' => 'Pembaca Aktif', 'value' => '50k+'],
                    ['label' => 'Kategori Buku', 'value' => '200+'],
                    ['label' => 'Rating Kepuasan', 'value' => '4.9/5'],
                ] as $stat)
                    <div class="text-center">
                        <p class="text-2xl font-semibold text-gray-900">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-sm tracking-wide text-gray-400 uppercase">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="catalog" class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between mb-12 md:flex-row">
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-semibold text-gray-900">Katalog Terbaru</h2>
                <p class="mt-1 text-sm text-gray-500">Pilihan editor minggu ini</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex gap-2 p-1 bg-gray-100 rounded-lg">
                    <button class="px-4 py-2 text-xs font-medium text-gray-900 bg-white rounded-md shadow-sm">Semua</button>
                    <button class="px-4 py-2 text-xs font-medium text-gray-500 hover:text-gray-900">Populer</button>
                    <button class="px-4 py-2 text-xs font-medium text-gray-500 hover:text-gray-900">Terbaru</button>
                </div>
            </div>
        </div>

        @livewire('book-catalog')
    </section>

    <section class="py-20 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-12 md:grid-cols-3">
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Pengiriman Terkurasi</h3>
                    <p class="text-sm leading-relaxed text-gray-500">Kami memastikan setiap buku dikemas dengan standar keamanan tinggi untuk menjaga kondisi fisik buku tetap sempurna.</p>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Pembayaran Fleksibel</h3>
                    <p class="text-sm leading-relaxed text-gray-500">Mulai dari transfer bank hingga Cash on Delivery (COD). Keamanan transaksi Anda adalah prioritas kami.</p>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Layanan Personal</h3>
                    <p class="text-sm leading-relaxed text-gray-500">Kesulitan mencari judul tertentu? Tim kami siap membantu mencarikan buku yang Anda butuhkan secara manual.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="p-12 text-center border border-gray-100 rounded-3xl bg-gray-50">
                <h2 class="text-3xl font-light text-gray-900">Ingin bertanya sesuatu?</h2>
                <p class="mt-4 text-gray-500">Kami senang berdiskusi tentang buku atau membantu kendala pesanan Anda.</p>
                <div class="flex justify-center gap-4 mt-10">
                    <a href="{{ route('contact') }}" 
                       class="px-8 py-3 text-sm font-medium text-white transition bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>