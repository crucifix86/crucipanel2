@section('title', ' - ' . __('shop.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('shop.configuration') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-2xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(request()->get('saved') == 1)
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {{ __('admin.configSaved') }}</span>
                </div>
                <script>
                    // Simple page refresh after 5 seconds
                    setTimeout(function() {
                        window.location.href = window.location.pathname;
                    }, 5000);
                </script>
            @endif
            <form method="post" action="{{ route('admin.shop.postSettings') }}">
                {!! csrf_field() !!}
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover popover="{{ __('shop.items_per_page_desc') }}" id="item_page"
                                                    name="item_page" value="{{ config('pw-config.shop.page') }}"
                                                    placeholder=" " required/>
                    <x-hrace009::label for="item_page">{{ __('shop.items_per_page') }}</x-hrace009::label>
                </div>
                <!-- Submit Button -->
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>
