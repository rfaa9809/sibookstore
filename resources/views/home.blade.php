<x-app-layout>
    {{-- Hero Section --}}
    <section class="px-4 py-16 text-white bg-gradient-to-br from-blue-600 to-blue-800">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="mb-4 text-4xl font-bold md:text-5xl">Temukan Buku Favoritmu</h1>
            <p class="text-lg text-blue-100">Ribuan judul buku tersedia, dikirim langsung ke pintumu.</p>
        </div>
    </section>

    {{-- Catalog Section --}}
    <section class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @livewire('book-catalog')
    </section>
</x-app-layout>