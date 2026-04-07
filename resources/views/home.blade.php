<x-app-layout>
    {{-- Hero Section --}}
    <section class="relative px-4 py-20 overflow-hidden text-white bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900">
        {{-- Elemen Dekoratif --}}
        <div class="absolute top-0 right-0 w-64 h-64 mt-[-50px] mr-[-50px] bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 mb-[-50px] ml-[-50px] bg-blue-400 opacity-10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-5xl mx-auto text-center">
            <span class="inline-block px-4 py-1 mb-4 text-xs font-semibold tracking-wider uppercase bg-blue-500 rounded-full bg-opacity-30">
                Koleksi Terlengkap 2026
            </span>
            <h1 class="mb-6 text-5xl font-extrabold leading-tight tracking-tight md:text-6xl">
                Jendela Dunia dalam <span class="text-blue-300">Genggamanmu</span>
            </h1>
            <p class="max-w-2xl mx-auto mb-10 text-lg text-blue-100 md:text-xl">
                Cari, pilih, dan beli buku favoritmu dengan sistem <span class="italic font-semibold">Payment at Delivery</span> yang aman dan terpercaya.
            </p>

            {{-- Search Bar Shortcut (Optional, kalo di component catalog belum ada) --}}
            <div class="flex flex-col items-center justify-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <a href="#catalog" class="px-8 py-3 font-bold text-blue-900 transition bg-white rounded-lg shadow-lg hover:bg-blue-50">
                    Mulai Belanja
                </a>
                <a href="{{ route('about') }}" class="px-8 py-3 font-bold transition-all border border-white rounded-lg hover:bg-white hover:text-blue-900">
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Feature Section --}}
    <section class="relative z-20 px-4 mx-auto mt-20 max-w-7xl">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            
            <div class="relative p-8 overflow-hidden transition-all duration-300 border border-white shadow-xl group bg-white/80 backdrop-blur-md rounded-2xl hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-24 h-24 -mt-8 -mr-8 transition-transform duration-500 rounded-full bg-blue-500/10 group-hover:scale-150"></div>
                
                <div class="relative flex flex-col items-center text-center">
                    <div class="flex items-center justify-center mb-5 text-white bg-blue-600 shadow-lg w-14 h-14 rounded-xl shadow-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Eksplorasi Tanpa Batas</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">Cari ribuan judul dari berbagai kategori favoritmu dengan sekali klik.</p>
                </div>
            </div>

            <div class="relative p-8 overflow-hidden transition-all duration-300 border border-white shadow-xl group bg-white/80 backdrop-blur-md rounded-2xl hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-24 h-24 -mt-8 -mr-8 transition-transform duration-500 rounded-full bg-indigo-500/10 group-hover:scale-150"></div>
                
                <div class="relative flex flex-col items-center text-center">
                    <div class="flex items-center justify-center mb-5 text-white bg-indigo-600 shadow-lg w-14 h-14 rounded-xl shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Keranjang Belanja</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">Kumpulkan buku incaranmu dan kelola pesanan dengan sangat mudah.</p>
                </div>
            </div>

            <div class="relative p-8 overflow-hidden transition-all duration-300 border border-white shadow-xl group bg-white/80 backdrop-blur-md rounded-2xl hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute top-0 right-0 w-24 h-24 -mt-8 -mr-8 transition-transform duration-500 rounded-full bg-emerald-500/10 group-hover:scale-150"></div>
                
                <div class="relative flex flex-col items-center text-center">
                    <div class="flex items-center justify-center mb-5 text-white shadow-lg w-14 h-14 bg-emerald-600 rounded-xl shadow-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 Pelajari 0a12.02 12.02 0 00-3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-3.14-.905-6.048-2.482-8.502z" />
                        </svg>
                    </div>
                    <h3 class="text-xl text-gray-900 fonat-bold">Katalog Buku</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">Nikmati fitur <strong>Katalog</strong>Pilih Katalog Buku untuk memudahkan mencari buku.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- Catalog Section --}}
    <section id="catalog" class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Katalog Buku</h2>
            <div class="flex-grow h-1 mx-4 bg-gray-100 rounded"></div>
        </div>
        
        @livewire('book-catalog')
    </section>
</x-app-layout>