<x-form-section submit="updatePinSettings">
    <x-slot name="title">
        {{ __('PIN Security Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage your PIN security. Enable PIN for an extra layer of security during login.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Enable/Disable PIN Toggle -->
        <div class="col-span-6 sm:col-span-4">
            <div class="flex items-center">
                <input type="checkbox" 
                       id="pin_enabled" 
                       wire:model="pinEnabled" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <label for="pin_enabled" class="ml-2">
                    {{ __('Enable PIN Security') }}
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                {{ __('When enabled, you will need to enter your PIN along with your password to login.') }}
            </p>
        </div>

        @if($pinEnabled)
            <!-- Current PIN -->
            @if(auth()->user()->qq)
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="current_pin" value="{{ __('Current PIN') }}"/>
                    <x-hrace009::input-box id="current_pin" type="password" class="mt-1 block w-full"
                                           wire:model="state.current_pin"
                                           placeholder="Enter current PIN to change it"
                                           autocomplete="current-pin"/>
                    <x-input-error for="current_pin" class="mt-2"/>
                </div>
            @endif

            <!-- New PIN -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="pin" value="{{ auth()->user()->qq ? __('New PIN') : __('Set PIN') }}"/>
                <x-hrace009::input-box id="pin" type="password" class="mt-1 block w-full" 
                                       wire:model="state.pin"
                                       placeholder="4-6 digits"
                                       autocomplete="new-pin"/>
                <x-input-error for="pin" class="mt-2"/>
            </div>

            <!-- Confirm PIN -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="pin_confirmation" value="{{ __('Confirm PIN') }}"/>
                <x-hrace009::input-box id="pin_confirmation" type="password" class="mt-1 block w-full"
                                       wire:model="state.pin_confirmation" 
                                       placeholder="Re-enter PIN"
                                       autocomplete="new-pin"/>
                <x-input-error for="pin_confirmation" class="mt-2"/>
            </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>