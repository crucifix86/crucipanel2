<div>
    <x-form-section submit="updateLanguage">
        <x-slot name="title">
            {{ __('Language Preference') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Choose your preferred language for the interface.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="language" value="{{ __('Language') }}" />
                <select id="language" wire:model="language" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="en">English</option>
                    <option value="id">Bahasa Indonesia</option>
                </select>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
