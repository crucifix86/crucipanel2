@php
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        return config($key, $default);
    }
}
@endphp
@section('title', ' - ' . __('Visit Reward Settings'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('Visit Reward Settings') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-2xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(request()->get('saved') == 1)
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {{ __('admin.configSaved') }}</span>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = window.location.pathname;
                    }, 2000);
                </script>
            @endif
            
            <form method="post" action="{{ route('admin.visit-reward.update') }}">
                @csrf
                
                <div class="relative z-0 mb-6 w-full group">
                    <div id="status_switch" class="flex ml-12">
                        <div class="pretty p-switch">
                            <input type="checkbox" id="enabled" name="enabled"
                                   value="{{ $settings->enabled ?? false }}"
                                   @if( $settings->enabled ?? false ) checked @endif
                                :popover="'Enable or disable visit rewards'"
                            />
                            <div class="state p-info">
                                <label for="enabled">
                                    @if( $settings->enabled ?? false )
                                        {{ __('donate.on') }}
                                    @else
                                        {{ __('donate.off') }}
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <x-hrace009::label for="status_switch">{{ __('donate.status') }}</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover id="title" name="title"
                                                    value="{{ $settings->title ?? 'Daily Visit Reward' }}"
                                                    placeholder=" " :popover="'Title shown to users'"
                                                    required/>
                    <x-hrace009::label for="title">Reward Title</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover id="description" name="description"
                                                    value="{{ $settings->description ?? 'Claim your daily reward for visiting!' }}"
                                                    placeholder=" " :popover="'Description shown to users'"/>
                    <x-hrace009::label for="description">Description</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover id="reward_amount" name="reward_amount"
                                                    value="{{ $settings->reward_amount ?? 10 }}"
                                                    placeholder=" " :popover="'Amount of reward to give'"
                                                    type="number" min="1" required/>
                    <x-hrace009::label for="reward_amount">Reward Amount</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::select-with-popover id="reward_type" name="reward_type" required
                                                     :popover="'Type of reward to give'">
                        <option class="dark:text-gray-500" value=""> - </option>
                        <option class="dark:text-gray-500" value="bonuses" 
                            {{ ($settings->reward_type ?? 'virtual') === 'bonuses' ? 'selected' : null }}>
                            {{ __('vote.create.type_bonusess') }}
                        </option>
                        <option class="dark:text-gray-500" value="virtual" 
                            {{ ($settings->reward_type ?? 'virtual') === 'virtual' ? 'selected' : null }}>
                            {{ config('pw-config.currency_name') }}
                        </option>
                        <option class="dark:text-gray-500" value="cubi" 
                            {{ ($settings->reward_type ?? 'virtual') === 'cubi' ? 'selected' : null }}>
                            {{ __('vote.create.type_cubi') }}
                        </option>
                    </x-hrace009::select-with-popover>
                    <x-hrace009::label for="reward_type">Reward Type</x-hrace009::label>
                </div>
                
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input-with-popover id="cooldown_hours" name="cooldown_hours"
                                                    value="{{ $settings->cooldown_hours ?? 24 }}"
                                                    placeholder=" " :popover="'Hours between claims (e.g., 24 for daily)'"
                                                    type="number" min="1" required/>
                    <x-hrace009::label for="cooldown_hours">Cooldown (Hours)</x-hrace009::label>
                </div>
                
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
            
            <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-300 dark:border-blue-600 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                    <i class="fas fa-info-circle"></i> How Visit Rewards Work
                </h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <li>• Users can claim rewards by visiting the site after the cooldown period</li>
                    <li>• The reward widget appears on all pages with server status</li>
                    <li>• Timer shows when the next reward is available</li>
                    <li>• Rewards are automatically added to user's balance</li>
                </ul>
            </div>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>