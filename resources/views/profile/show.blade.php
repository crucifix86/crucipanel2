@section('title', ' - ' . __('general.dashboard.profile.header'))
<x-hrace009.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('general.dashboard.profile.header') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border/>
            @endif

            @if ( $api->online )
                @livewire('profile.list-character')

                <x-section-border/>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border/>
                @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-pin-form')
                    </div>
                    <x-section-border/>
                @endif
            @endif


            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-from-other-browser')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border/>

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
            </div>
        </div>
    </x-slot>
</x-hrace009.layouts.app>
