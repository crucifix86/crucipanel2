@section('title', ' - ' . __('auth.form.resetPassword') )
<x-hrace009.layouts.guest>
    <x-hrace009::auth.label-title>
        {{ __('auth.form.resetPassword') }}
    </x-hrace009::auth.label-title>
    <x-hrace009::validation-errors class="mb-4"/>
    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $request->email }}">
        
        <x-hrace009::input.label-group for="password" label="New Password">
            <x-hrace009::input-text id="password" name="password" type="password" required autocomplete="new-password" autofocus/>
        </x-hrace009::input.label-group>
        
        <x-hrace009::input.label-group for="password_confirmation" label="Confirm New Password">
            <x-hrace009::input-text id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"/>
        </x-hrace009::input.label-group>
        
        @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
            <x-hrace009::input.label-group for="pin" label="New PIN">
                <x-hrace009::input-text id="pin" name="pin" type="password" required/>
            </x-hrace009::input.label-group>
            
            <x-hrace009::input.label-group for="pin_confirmation" label="Confirm New PIN">
                <x-hrace009::input-text id="pin_confirmation" name="pin_confirmation" type="password" required/>
            </x-hrace009::input.label-group>
        @endif
        
        @if( config('pw-config.system.apps.captcha') )
            <x-hrace009::captcha/>
        @endif

        <x-hrace009::button>
            {{ __('auth.form.resetPassword') }}
        </x-hrace009::button>
    </form>
</x-hrace009.layouts.guest>
