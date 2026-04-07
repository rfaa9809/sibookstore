<x-app-layout>
    <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8 py-14">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="mb-3 text-4xl font-bold text-gray-800">Tentang Kami</h1>
            <p class="text-lg text-gray-500">Mendekatkan buku ke tangan pembaca sejak 2024.</p>
        </div>

        {{-- Story --}}
        <div class="grid items-center grid-cols-1 gap-10 mb-16 md:grid-cols-2">
            <div class="space-y-4">
                <h2 class="text-2xl font-semibold text-gray-800">Cerita Kami</h2>
                <p class="leading-relaxed text-gray-600">
                    BookStore lahir dari kecintaan terhadap buku dan keyakinan bahwa setiap orang berhak
                    mendapatkan akses mudah ke bacaan berkualitas. Kami menyediakan ribuan judul dari
                    berbagai kategori — fiksi, nonfiksi, sains, bisnis, dan masih banyak lagi.
                </p>
                <p class="leading-relaxed text-gray-600">
                    Dengan sistem pemesanan yang mudah dan pengiriman yang andal, kami memastikan buku
                    sampai ke tanganmu dalam kondisi terbaik.
                </p>
            </div>
            <div class="flex items-center justify-center p-8 bg-blue-50 rounded-2xl">
                <div class="text-center">
                    <div class="mb-3 text-6xl">📚</div>
                    <p class="text-lg font-semibold text-blue-700">Ribuan judul buku</p>
                    <p class="text-sm text-blue-500">siap dikirim ke seluruh Indonesia</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-6 mb-16 md:grid-cols-4">
            @foreach ([
                ['value' => '5.000+', 'label' => 'Judul Buku'],
                ['value' => '200+',   'label' => 'Kategori'],
                ['value' => '10.000+','label' => 'Pelanggan'],
                ['value' => '4.9★',   'label' => 'Rating Kepuasan'],
            ] as $stat)
                <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-xl">
                    <p class="text-3xl font-bold text-blue-600">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Values --}}
        <div class="mb-16">
            <h2 class="mb-8 text-2xl font-semibold text-center text-gray-800">Nilai Kami</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ([
                    ['icon' => '🎯', 'title' => 'Kurasi Berkualitas',   'desc' => 'Setiap buku dipilih dengan cermat untuk memastikan kamu mendapatkan yang terbaik.'],
                    ['icon' => '🚚', 'title' => 'Pengiriman Terpercaya','desc' => 'Buku dikemas dengan aman dan dikirim tepat waktu ke seluruh penjuru Indonesia.'],
                    ['icon' => '💬', 'title' => 'Layanan Responsif',    'desc' => 'Tim kami siap membantu pertanyaan dan keluhan kamu dengan cepat dan ramah.'],
                ] as $val)
                    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                        <div class="mb-3 text-3xl">{{ $val['icon'] }}</div>
                        <h3 class="mb-2 font-semibold text-gray-800">{{ $val['title'] }}</h3>
                        <p class="text-sm leading-relaxed text-gray-500">{{ $val['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CTA --}}
        <div class="p-10 text-center text-white bg-blue-600 rounded-2xl">
            <h2 class="mb-3 text-2xl font-bold">Mulai Berbelanja Sekarang</h2>
            <p class="mb-6 text-blue-100">Temukan buku yang kamu cari dari koleksi kami yang terus bertambah.</p>
            <a href="{{ route('home') }}"
               class="inline-block px-8 py-3 font-semibold text-blue-600 transition bg-white rounded-xl hover:bg-blue-50">
                Lihat Koleksi Buku
            </a>
        </div>

    </div>
</x-app-layout>