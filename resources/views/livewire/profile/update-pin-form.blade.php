<x-form-section submit="updatePin">
    <x-slot name="title">
        {{ __('general.dashboard.profile.updatePin.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('general.dashboard.profile.updatePin.description') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_pin" value="{{ __('general.dashboard.profile.updatePin.current') }}"/>
            <x-hrace009::input-box id="current_pin" type="password" class="mt-1 block w-full"
                                   wire:model="state.current_pin"
                                   autocomplete="current-pin"/>
            <x-input-error for="current_pin" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="pin" value="{{ __('general.dashboard.profile.updatePin.new') }}"/>
            <x-hrace009::input-box id="pin" type="password" class="mt-1 block w-full" wire:model="state.pin"
                                   autocomplete="new-pin"/>
            <x-input-error for="pin" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="pin_confirmation" value="{{ __('general.dashboard.profile.updatePin.confirm') }}"/>
            <x-hrace009::input-box id="pin_confirmation" type="password" class="mt-1 block w-full"
                                   wire:model="state.pin_confirmation" autocomplete="new-pin"/>
            <x-input-error for="pin_confirmation" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('general.saved') }}
        </x-action-message>

        <x-button>
            {{ __('general.Save') }}
        </x-button>
    </x-slot>
</x-form-section>
