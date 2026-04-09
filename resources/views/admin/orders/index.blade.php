<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Kelola Pesanan
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @livewire('admin.order-table')

    </div>
</x-admin-layout>