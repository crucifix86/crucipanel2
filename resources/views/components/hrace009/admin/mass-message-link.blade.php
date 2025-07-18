<!-- Mass Message link -->
<div>
    <a
        href="{{ route('admin.mass-message.index') }}"
        class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary {{ request()->routeIs('admin.mass-message.*') ? 'bg-primary-100 dark:bg-primary' : '' }}"
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
                    d="M8 10h.01M12 10h.01M16 10h.01M21 16.5A2.5 2.5 0 0118.5 19H6a2.5 2.5 0 01-2.5-2.5V8a2.5 2.5 0 012.5-2.5h12.5A2.5 2.5 0 0121 8v8.5zM3.5 7.5L12 13l8.5-5.5"
                />
            </svg>
        </span>
        <span class="ml-2 text-sm">Mass Message</span>
    </a>
</div>