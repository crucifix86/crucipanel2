<!-- Language button -->
<div class="relative" x-data="{ open: false }">
    <button
        @click="open = !open; $nextTick(() => { if(open){ $refs.languageMenu.focus() } })"
        type="button"
        aria-haspopup="true"
        :aria-expanded="open ? 'true' : 'false'"
        style="background: none !important; border: none !important; padding: 0 !important; color: rgba(255,255,255,0.9) !important; font-size: 0.875rem !important; cursor: pointer; display: inline-flex; align-items: center; font-family: inherit;"
        {{-- Removed all Tailwind classes, using forceful inline styles --}}
    >
        {{ __('general.language', []) }}
        {{-- Chevron down icon for dropdown indication --}}
        <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="fill: rgba(255,255,255,0.9) !important;">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="open"
        x-ref="languageMenu"
        x-transition:enter="transition-all transform ease-out"
        x-transition:enter-start="translate-y-1/2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition-all transform ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-1/2 opacity-0"
        @click.away="open = false"
        @keydown.escape="open = false"
        class="absolute right-0 w-48 py-1 bg-white rounded-md shadow-lg top-12 ring-1 ring-black ring-opacity-5 dark:bg-dark focus:outline-none"
        tabindex="-1"
        role="menu"
        aria-orientation="vertical"
        aria-label="Language menu"
    >
        @foreach( $languages as $language )
            <a role="menuitem" href="{{ Request::url() . '?language=' . $language }}"
               class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary"
            >
                <img class="inline-flex"
                     src="{{ asset( 'img/flags/' . $language . '.png' ) }}" alt=""/> {{ __( 'language.' . $language ) }}
            </a>
        @endforeach
    </div>
</div>
