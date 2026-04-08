<x-app-layout>
    <div class="max-w-5xl px-4 py-20 mx-auto sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="max-w-2xl mb-20">
            <span class="inline-block px-3 py-1 mb-4 text-xs font-medium tracking-widest text-indigo-600 uppercase rounded bg-indigo-50">
                Profil Perusahaan
            </span>
            <h1 class="text-4xl font-light tracking-tight text-gray-900 md:text-5xl">
                Si <span class="font-serif italic text-indigo-600">Book</span> Store 
            </h1>
            <p class="mt-6 text-lg leading-relaxed text-gray-500">
                Didirikan pada tahun 2024, kami hadir untuk menyederhanakan cara Anda menemukan literatur berkualitas di era digital.
            </p>
        </div>

        {{-- Story Section --}}
        <div class="grid items-start grid-cols-1 gap-16 mb-24 md:grid-cols-2">
            <div>
                <h2 class="text-sm font-bold tracking-widest text-gray-400 uppercase">Visi & Misi</h2>
                <div class="mt-6 space-y-6">
                    <p class="leading-relaxed text-gray-600">
                        BookStore tidak hanya sekadar toko. Kami adalah kurator yang percaya bahwa akses terhadap pengetahuan haruslah tanpa hambatan. Fokus kami adalah menghadirkan judul-judul yang mampu mengubah perspektif, mulai dari fiksi yang menggugah imajinasi hingga literatur teknis yang mendukung karier.
                    </p>
                    <p class="pl-6 italic leading-relaxed text-gray-600 border-l-2 border-indigo-100">
                        "Kami percaya bahwa setiap buku memiliki pembaca sejatinya sendiri, dan tugas kami adalah mempertemukan mereka."
                    </p>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute transition duration-1000 -inset-2 bg-gradient-to-r from-indigo-100 to-gray-100 rounded-2xl blur opacity-30 group-hover:opacity-50"></div>
                <div class="relative p-10 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <div class="text-center">
                        <p class="text-5xl font-light text-indigo-600">5.000+</p>
                        <p class="mt-2 text-sm tracking-widest text-gray-400 uppercase">Koleksi Terkurasi</p>
                        <div class="pt-8 mt-8 border-t border-gray-50">
                            <p class="text-sm leading-relaxed text-gray-500">
                                Dari penulis lokal berbakat hingga karya internasional pemenang penghargaan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Simple Stats Grid --}}
        <div class="grid grid-cols-2 gap-px mb-24 overflow-hidden bg-gray-100 border border-gray-100 rounded-2xl md:grid-cols-4">
            @foreach ([
                ['value' => '200+',   'label' => 'Kategori'],
                ['value' => '10k+',   'label' => 'Pelanggan'],
                ['value' => '4.9/5',  'label' => 'Rating'],
                ['value' => '24/7',   'label' => 'Dukungan'],
            ] as $stat)
                <div class="p-8 text-center bg-white">
                    <p class="text-2xl font-medium text-gray-900">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-xs tracking-wide text-gray-400 uppercase">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Values Section --}}
        <div class="mb-24">
            <h2 class="mb-12 text-sm font-bold tracking-widest text-center text-gray-400 uppercase">Komitmen Kami</h2>
            <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Kurasi Ketat', 'desc' => 'Hanya buku dalam kondisi terbaik dan konten berkualitas yang masuk ke etalase kami.'],
                    ['title' => 'Logistik Aman', 'desc' => 'Standar pengemasan berlapis untuk memastikan buku tiba tanpa sudut yang tertekuk.'],
                    ['title' => 'Transparansi', 'desc' => 'Harga jujur dan sistem pelacakan pesanan yang real-time untuk kenyamanan Anda.'],
                ] as $val)
                    <div class="group">
                        <div class="w-8 h-1 mb-4 transition-all duration-300 bg-indigo-100 group-hover:w-16"></div>
                        <h3 class="mb-3 font-medium text-gray-900">{{ $val['title'] }}</h3>
                        <p class="text-sm leading-relaxed text-gray-500">{{ $val['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Minimalist CTA --}}
        <div class="relative overflow-hidden bg-gray-900 rounded-3xl">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 translate-x-1/2 -translate-y-1/2 bg-white rounded-full blur-3xl"></div>
            </div>
            <div class="relative px-8 py-16 text-center">
                <h2 class="text-2xl font-light text-white">Siap memulai perjalanan literasi Anda?</h2>
                <div class="mt-8">
                    <a href="{{ route('home') }}"
                       class="inline-block px-10 py-3 text-sm font-medium text-gray-900 transition bg-white rounded-lg hover:bg-gray-100">
                        Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>