<!-- Welcome Message link -->
<div>
    <a
        href="{{ route('admin.welcome-message.index') }}"
        class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary {{ request()->routeIs('admin.welcome-message.*') ? 'bg-primary-100 dark:bg-primary' : '' }}"
        role="menuitem"
    >
        <span aria-hidden="true">
            <svg
                class="w-5 h-5"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                />
            </svg>
        </span>
        <span class="ml-2 text-sm">Welcome Message</span>
    </a>
</div>