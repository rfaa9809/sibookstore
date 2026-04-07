<div class="relative">
    <a href="{{ route('cart.index') }}" class="flex items-center text-gray-600 transition hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        @if ($count > 0)
            <span class="absolute flex items-center justify-center w-5 h-5 text-xs font-medium text-white bg-blue-600 rounded-full -top-2 -right-2">
                {{ $count > 99 ? '99+' : $count }}
            </span>
        @endif
    </a>
</div>