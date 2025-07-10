@section('title', ' - ' . __('news.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('news.config') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-2xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            <form method="post" action="{{ route('admin.news.postSettings') }}">
                {!! csrf_field() !!}
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover id="article_page" name="article_page"
                                                    value="{{ config('pw-config.news.page') }}"
                                                    placeholder=" " required
                                                    :popover="__('news.articles_per_page_desc')"/>
                    <x-hrace009::label for="article_page">{{ __('news.articles_per_page') }}</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::label for="default_og_logo">{{ __('news.default_og_logo') }}</x-hrace009::label>
                    
                    {{-- Current Logo Preview --}}
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('news.current_logo_preview') }}:</p>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset(config('pw-config.news.default_og_logo', 'img/logo/crucifix_logo.svg')) }}" 
                                 alt="Current Default News Logo" 
                                 class="max-h-20 max-w-40 bg-white dark:bg-gray-800 p-2 rounded border border-gray-300 dark:border-gray-600">
                            <div class="text-sm">
                                <p class="font-semibold text-gray-700 dark:text-gray-300">{{ __('news.current_path') }}:</p>
                                <code class="text-xs bg-gray-200 dark:bg-gray-800 px-2 py-1 rounded">{{ config('pw-config.news.default_og_logo', 'img/logo/crucifix_logo.svg') }}</code>
                            </div>
                        </div>
                    </div>
                    
                    <x-hrace009::input-with-popover id="default_og_logo" name="default_og_logo"
                                                    value="{{ config('pw-config.news.default_og_logo') }}"
                                                    placeholder="img/logo/crucifix_logo.svg" required
                                                    :popover="__('news.default_og_logo_desc', ['default' => 'img/logo/crucifix_logo.svg'])"/>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('news.default_og_logo_help') }}
                    </p>
                    <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <i class="fas fa-info-circle mr-1"></i>
                            {{ __('news.logo_path_examples') }}:
                        </p>
                        <ul class="mt-1 text-xs text-blue-600 dark:text-blue-400 space-y-1">
                            <li>• img/logo/crucifix_logo.svg</li>
                            <li>• img/logo/haven_perfect_world_logo.svg</li>
                            <li>• img/logo/your-custom-logo.png</li>
                        </ul>
                    </div>
                </div>
                <!-- Submit Button -->
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>
