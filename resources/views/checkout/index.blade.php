<x-app-layout>
    <div class="max-w-5xl px-4 py-10 mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
            <p class="mt-1 text-sm text-gray-500">Lengkapi informasi pengiriman dan pembayaran.</p>
        </div>

        @livewire('checkout-form')

    </div>
</x-app-layout>