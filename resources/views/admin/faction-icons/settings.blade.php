<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Faction Icon Settings') }}
            </h2>
            <a href="{{ route('admin.faction-icons.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.faction-icons.update-settings') }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Enable Faction Icons -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="hidden" name="enabled" value="0">
                                        <input type="checkbox" name="enabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings->enabled ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Enable faction icon uploads') }}</span>
                                    </label>
                                </div>

                                <!-- Icon Size -->
                                <div>
                                    <label for="icon_size" class="block text-sm font-medium text-gray-700">{{ __('Icon Size (pixels)') }}</label>
                                    <input type="number" name="icon_size" id="icon_size" value="{{ $settings->icon_size }}" min="16" max="128" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <p class="mt-1 text-sm text-gray-500">{{ __('Icons will be resized to this dimension (square).') }}</p>
                                    @error('icon_size')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Max File Size -->
                                <div>
                                    <label for="max_file_size" class="block text-sm font-medium text-gray-700">{{ __('Max File Size (bytes)') }}</label>
                                    <input type="number" name="max_file_size" id="max_file_size" value="{{ $settings->max_file_size }}" min="10240" max="5242880" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <p class="mt-1 text-sm text-gray-500">{{ __('Current:') }} {{ $settings->getMaxFileSizeInMb() }}MB</p>
                                    @error('max_file_size')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Cost Settings -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Cost Settings') }}</h3>
                                    
                                    <!-- Virtual Currency Cost -->
                                    <div class="mb-4">
                                        <label for="cost_virtual" class="block text-sm font-medium text-gray-700">{{ __('Virtual Currency Cost') }}</label>
                                        <input type="number" name="cost_virtual" id="cost_virtual" value="{{ $settings->cost_virtual }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Amount of') }} {{ config('pw-config.currency_name', 'Virtual Currency') }} {{ __('to charge') }}</p>
                                        @error('cost_virtual')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gold Cost -->
                                    <div>
                                        <label for="cost_gold" class="block text-sm font-medium text-gray-700">{{ __('Gold Cost') }}</label>
                                        <input type="number" name="cost_gold" id="cost_gold" value="{{ $settings->cost_gold }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Amount in copper (10000 = 1 gold)') }}</p>
                                        @error('cost_gold')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Approval Settings -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Approval Settings') }}</h3>
                                    
                                    <!-- Require Approval -->
                                    <div class="mb-4">
                                        <label class="flex items-center">
                                            <input type="hidden" name="require_approval" value="0">
                                            <input type="checkbox" name="require_approval" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings->require_approval ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Require admin approval for new icons') }}</span>
                                        </label>
                                    </div>

                                    <!-- Auto Deploy -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="hidden" name="auto_deploy" value="0">
                                            <input type="checkbox" name="auto_deploy" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings->auto_deploy ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Automatically deploy approved icons to game server') }}</span>
                                        </label>
                                        <p class="ml-6 mt-1 text-xs text-gray-500">{{ __('When enabled, approved icons will be automatically copied to the game server.') }}</p>
                                    </div>
                                </div>

                                <!-- Allowed Formats -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Allowed Image Formats') }}</h3>
                                    
                                    <div class="space-y-2">
                                        @foreach(['png', 'jpg', 'jpeg', 'gif'] as $format)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="allowed_formats[]" value="{{ $format }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array($format, $settings->allowed_formats ?? []) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-600">{{ strtoupper($format) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('allowed_formats')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center justify-end">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        {{ __('Save Settings') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>