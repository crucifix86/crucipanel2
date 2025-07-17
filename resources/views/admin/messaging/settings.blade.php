@section('title', ' - ' . __('admin.messaging.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('admin.messaging.settings') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-2xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {{ session('success') }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('admin.messaging.settings.update') }}">
                @csrf
                
                <!-- Messaging Enabled -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="messaging_enabled" value="1" 
                               {{ $settings->messaging_enabled ? 'checked' : '' }}
                               class="mr-2 leading-tight rounded dark:bg-primary-darker border-gray-300 dark:border-gray-600 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                        <span class="text-sm dark:text-gray-300">
                            {{ __('admin.messaging.enable_messaging') }}
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('admin.messaging.enable_messaging_desc') }}
                    </p>
                </div>

                <!-- Profile Wall Enabled -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="profile_wall_enabled" value="1" 
                               {{ $settings->profile_wall_enabled ? 'checked' : '' }}
                               class="mr-2 leading-tight rounded dark:bg-primary-darker border-gray-300 dark:border-gray-600 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                        <span class="text-sm dark:text-gray-300">
                            {{ __('admin.messaging.enable_profile_wall') }}
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('admin.messaging.enable_profile_wall_desc') }}
                    </p>
                </div>

                <!-- Message Rate Limit -->
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover 
                        popover="{{ __('admin.messaging.message_rate_limit_desc') }}" 
                        id="message_rate_limit"
                        name="message_rate_limit" 
                        type="number"
                        min="1"
                        max="100"
                        value="{{ $settings->message_rate_limit }}"
                        placeholder=" " 
                        required/>
                    <x-hrace009::label for="message_rate_limit">
                        {{ __('admin.messaging.message_rate_limit') }}
                    </x-hrace009::label>
                </div>

                <!-- Wall Message Rate Limit -->
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover 
                        popover="{{ __('admin.messaging.wall_message_rate_limit_desc') }}" 
                        id="wall_message_rate_limit"
                        name="wall_message_rate_limit" 
                        type="number"
                        min="1"
                        max="50"
                        value="{{ $settings->wall_message_rate_limit }}"
                        placeholder=" " 
                        required/>
                    <x-hrace009::label for="wall_message_rate_limit">
                        {{ __('admin.messaging.wall_message_rate_limit') }}
                    </x-hrace009::label>
                </div>

                <!-- Submit Button -->
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>