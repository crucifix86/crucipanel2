<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Welcome Message Settings') }}
            </h2>
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

                        <form method="POST" action="{{ route('admin.welcome-message.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Enable Welcome Message -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="hidden" name="enabled" value="0">
                                        <input type="checkbox" name="enabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings && $settings->enabled ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Enable welcome message for new users') }}</span>
                                    </label>
                                </div>

                                <!-- Message Subject -->
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('Message Subject') }}</label>
                                    <input type="text" name="subject" id="subject" value="{{ $settings->subject ?? 'Welcome to ' . config('app.name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @error('subject')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Message Content -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">{{ __('Message Content') }}</label>
                                    <textarea name="message" id="message" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ $settings->message ?? "Welcome to our server!\n\nWe're excited to have you join our community. This message contains a special reward for new players.\n\nTo claim your reward, simply read this message. The reward will be automatically added to your account.\n\nIf you have any questions, feel free to reach out to our support team.\n\nEnjoy your adventure!" }}</textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Verification Settings -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Email Verification') }}</h3>
                                    
                                    <!-- Enable Email Verification -->
                                    <div class="mb-4">
                                        <label class="flex items-center">
                                            <input type="hidden" name="email_verification_enabled" value="0">
                                            <input type="checkbox" name="email_verification_enabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings && $settings->email_verification_enabled ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Require email verification for new users') }}</span>
                                        </label>
                                        <p class="ml-6 mt-1 text-xs text-gray-500">{{ __('Users must verify their email address before accessing the panel') }}</p>
                                    </div>
                                </div>

                                <!-- Reward Settings -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Reward Settings') }}</h3>
                                    
                                    <!-- Enable Reward -->
                                    <div class="mb-4">
                                        <label class="flex items-center">
                                            <input type="hidden" name="reward_enabled" value="0">
                                            <input type="checkbox" name="reward_enabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $settings && $settings->reward_enabled ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Enable reward for reading welcome message') }}</span>
                                        </label>
                                    </div>

                                    <!-- Reward Type -->
                                    <div class="mb-4">
                                        <label for="reward_type" class="block text-sm font-medium text-gray-700">{{ __('Reward Type') }}</label>
                                        <select name="reward_type" id="reward_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            <option value="virtual" {{ ($settings && $settings->reward_type == 'virtual') ? 'selected' : '' }}>{{ config('pw-config.currency_name', 'Virtual Currency') }}</option>
                                            <option value="cubi" {{ ($settings && $settings->reward_type == 'cubi') ? 'selected' : '' }}>{{ __('Gold') }}</option>
                                            <option value="bonus" {{ ($settings && $settings->reward_type == 'bonus') ? 'selected' : '' }}>{{ __('Bonus Points') }}</option>
                                        </select>
                                        @error('reward_type')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Reward Amount -->
                                    <div>
                                        <label for="reward_amount" class="block text-sm font-medium text-gray-700">{{ __('Reward Amount') }}</label>
                                        <input type="number" name="reward_amount" id="reward_amount" value="{{ $settings->reward_amount ?? 1000 }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        @error('reward_amount')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
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