<li class="nav-item" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <a href="{{ route('messages.inbox') }}"
       class="nav-link px-3 py-2 text-base rounded {{ $status == 'true' ? 'bg-gray-900 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-700 hover:text-white' }}"
       :class="{ 'bg-gray-700': open }"
    >
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span>{{ __('messages.inbox') }}</span>
            @if($unreadCount > 0)
                <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                    {{ $unreadCount }}
                </span>
            @endif
        </div>
    </a>
    
    <ul class="absolute left-0 z-10 hidden w-48 py-2 mt-2 bg-white rounded-md shadow-xl dark:bg-gray-800"
        :class="{ 'hidden': !open }"
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
    >
        <li>
            <a href="{{ route('messages.inbox') }}"
               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                {{ __('messages.inbox') }}
                @if($unreadCount > 0)
                    <span class="ml-2 text-xs text-red-600 dark:text-red-400">({{ $unreadCount }})</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('messages.outbox') }}"
               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                {{ __('messages.outbox') }}
            </a>
        </li>
        <li>
            <a href="{{ route('messages.compose') }}"
               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                {{ __('messages.compose') }}
            </a>
        </li>
    </ul>
</li>