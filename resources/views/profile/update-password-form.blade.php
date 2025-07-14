<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('profile.password.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile.password.description') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('profile.password.current') }}"/>
            <x-hrace009::input-box id="current_password" type="password" class="mt-1 block w-full"
                                   wire:model="state.current_password" autocomplete="current-password"/>
            <x-input-error for="current_password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('profile.password.new') }}"/>
            <x-hrace009::input-box id="password" type="password" class="mt-1 block w-full"
                                   wire:model="state.password" autocomplete="new-password"/>
            <x-input-error for="password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('profile.password.confirm') }}"/>
            <x-hrace009::input-box id="password_confirmation" type="password" class="mt-1 block w-full"
                                   wire:model="state.password_confirmation" autocomplete="new-password"/>
            <x-input-error for="password_confirmation" class="mt-2"/>
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
