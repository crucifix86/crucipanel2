<div class="dark:bg-darker shadow-lg hover:shadow-xl rounded-lg mb-6 border dark:border-primary-light">
    <div class="p-2 dark:text-primary-light border-b dark:border-primary-light">
        <h2 class="text-2xl font-semibold ">{{ __('general.arena.title') }}</h2>
    </div>
    <div class="p-2">
        <p>{{ __('general.arena.info') }}</p>
        <p class="mb-2"><strong>Callback URL:</strong> <code class="text-sm">{{ route('api.arenatop100') }}</code></p>
        
        @if(config('arena.username'))
            <p class="mb-2"><strong>Current Arena Username:</strong> <code class="text-sm">{{ config('arena.username') }}</code></p>
            <p class="mb-2"><strong>Example Vote URL:</strong></p>
            <code class="text-xs block p-2 bg-gray-100 dark:bg-gray-800 rounded">https://www.arena-top100.com/index.php?a=in&u={{ config('arena.username') }}&callback={{ urlencode(base64_encode(route('api.arenatop100') . '?userid=1&logid=1')) }}</code>
            
            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-500 dark:border-blue-400 rounded">
                <p class="text-sm"><strong>Important:</strong> Make sure your Arena Top 100 account has:</p>
                <ul class="text-sm list-disc ml-5 mt-2">
                    <li>Callback/Incentive system enabled</li>
                    <li>Your server added to the account</li>
                    <li>The correct callback URL configured</li>
                </ul>
            </div>
        @else
            <p class="text-red-600 dark:text-red-400">Arena username not configured!</p>
        @endif
    </div>
</div>
