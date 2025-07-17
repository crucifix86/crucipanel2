@php
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        return config($key, $default);
    }
}
@endphp
@section('title', ' - ' . __('vote.arena.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('vote.arena.header') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w mx-auto mt-6 ml-6 mr-6">
            <x-hrace009::admin.automate-panel/>
            <x-hrace009::admin.arena-info/>
        </div>
        <div class="max-w-2xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(request()->get('saved') == 1)
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {{ __('admin.configSaved') }}</span>
                </div>
                <script>
                    // Simple page refresh after 5 seconds
                    setTimeout(function() {
                        window.location.href = window.location.pathname;
                    }, 5000);
                </script>
            @endif
            <form method="post" action="{{ route('admin.vote.arena.submit') }}">
                {!! csrf_field() !!}
                <div class="relative z-0 mb-6 w-full group">
                    <div id="status_switch" class="flex ml-12">
                        <div class="pretty p-switch">
                            <input type="checkbox" id="status" name="status"
                                   value="{{ get_setting('arena.status', config('arena.status')) }}"
                                   @if( get_setting('arena.status', config('arena.status')) === true ) checked @endif
                                @popper({{ __('vote.arena.status_desc') }})
                            />
                            <div class="state p-info">
                                <label for="status">
                                    @if( get_setting('arena.status') === true )
                                        {{ __('donate.on') }}
                                    @else
                                        {{ __('donate.off') }}
                                    @endif</label>
                            </div>
                        </div>
                    </div>
                    <x-hrace009::label for="status_switch">{{ __('donate.status') }}</x-hrace009::label>
                </div>
                @if( get_setting('arena.status') === true )
                    <div class="relative z-0 mb-6 w-full group">
                        <x-hrace009::input-with-popover id="username" name="username"
                                                        value="{{ get_setting('arena.username') }}"
                                                        placeholder=" " :popover="__('vote.arena.arena_username_desc')"
                                                        required/>
                        <x-hrace009::label for="username">{{ __('vote.arena.arena_username') }}</x-hrace009::label>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <x-hrace009::input-with-popover id="reward" name="reward"
                                                        value="{{ get_setting('arena.reward') }}"
                                                        placeholder=" " :popover="__('vote.arena.reward_desc')"
                                                        required/>
                        <x-hrace009::label for="reward">{{ __('vote.arena.reward') }}</x-hrace009::label>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <x-hrace009::select-with-popover id="reward_type" name="reward_type" required
                                                         :popover="__('vote.arena.reward_type_desc')">
                            <option class="dark:text-gray-500"
                                    value=""> -
                            </option>
                            <option class="dark:text-gray-500"
                                    value="bonusess" {{ get_setting('arena.reward_type') === 'bonusess' ? 'selected' : null }}> {{ __('vote.create.type_bonusess') }}
                            </option>
                            <option class="dark:text-gray-500"
                                    value="virtual" {{ get_setting('arena.reward_type') === 'virtual' ? 'selected' : null }}> {{ config('pw-config.currency_name') }}
                            </option>
                            <option class="dark:text-gray-500"
                                    value="cubi" {{ get_setting('arena.reward_type') === 'cubi' ? 'selected' : null }}> {{ __('vote.create.type_cubi') }}
                            </option>
                        </x-hrace009::select-with-popover>
                        <x-hrace009::label for="reward_type">{{ __('vote.arena.reward_type') }}</x-hrace009::label>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <x-hrace009::input-with-popover id="time" name="time"
                                                        value="{{ get_setting('arena.time') }}"
                                                        placeholder=" " :popover="__('vote.arena.time_desc')" required/>
                        <x-hrace009::label for="time">{{ __('vote.arena.time') }}</x-hrace009::label>
                    </div>
                    
                    <!-- Test Mode Section -->
                    <div class="mt-8 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-600 rounded-lg">
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-4">
                            ⚠️ Testing Mode - DISABLE IN PRODUCTION!
                        </h3>
                        
                        <div class="relative z-0 mb-6 w-full group">
                            <div id="test_mode_switch" class="flex ml-12">
                                <div class="pretty p-switch p-fill">
                                    <input type="checkbox" id="test_mode" name="test_mode"
                                           value="{{ get_setting('arena.test_mode', false) }}"
                                           @if( get_setting('arena.test_mode', false) === true ) checked @endif
                                        @popper(Always return successful vote in callbacks - for testing only!)
                                    />
                                    <div class="state p-danger">
                                        <label for="test_mode">
                                            @if( get_setting('arena.test_mode', false) === true )
                                                {{ __('donate.on') }}
                                            @else
                                                {{ __('donate.off') }}
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <x-hrace009::label for="test_mode_switch">Force Successful Votes</x-hrace009::label>
                        </div>
                        
                        <div class="relative z-0 mb-6 w-full group">
                            <div id="test_mode_clear_timer_switch" class="flex ml-12">
                                <div class="pretty p-switch p-fill">
                                    <input type="checkbox" id="test_mode_clear_timer" name="test_mode_clear_timer"
                                           value="{{ get_setting('arena.test_mode_clear_timer', false) }}"
                                           @if( get_setting('arena.test_mode_clear_timer', false) === true ) checked @endif
                                        @popper(Bypass cooldown timer - allows unlimited voting for testing!)
                                    />
                                    <div class="state p-danger">
                                        <label for="test_mode_clear_timer">
                                            @if( get_setting('arena.test_mode_clear_timer', false) === true )
                                                {{ __('donate.on') }}
                                            @else
                                                {{ __('donate.off') }}
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <x-hrace009::label for="test_mode_clear_timer_switch">Clear Vote Timer</x-hrace009::label>
                        </div>
                        
                        <p class="text-sm text-red-700 dark:text-red-300 mt-2">
                            <strong>Warning:</strong> These options are for testing only. They will:
                            <br>• Allow users to vote unlimited times
                            <br>• Always give rewards regardless of actual Arena vote
                            <br>• Simulate immediate callbacks without visiting Arena
                        </p>
                    </div>
                    
                    <!-- Vote Security Settings Section -->
                    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-300 dark:border-blue-600 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4">
                            🛡️ Vote Security Settings
                        </h3>
                        
                        <div class="relative z-0 mb-6 w-full group">
                            <div id="ip_limit_enabled_switch" class="flex ml-12">
                                <div class="pretty p-switch">
                                    <input type="checkbox" id="ip_limit_enabled" name="ip_limit_enabled"
                                           value="1"
                                           @if( \App\Models\VoteSecuritySetting::getSettings()->ip_limit_enabled ) checked @endif
                                        @popper(Enable IP-based vote limiting to prevent abuse)
                                    />
                                    <div class="state p-info">
                                        <label for="ip_limit_enabled">
                                            {{ \App\Models\VoteSecuritySetting::getSettings()->ip_limit_enabled ? __('donate.on') : __('donate.off') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <x-hrace009::label for="ip_limit_enabled_switch">Enable IP Limits</x-hrace009::label>
                        </div>
                        
                        <div class="relative z-0 mb-6 w-full group">
                            <x-hrace009::input-with-popover id="max_votes_per_ip_daily" name="max_votes_per_ip_daily"
                                                            type="number" min="1" max="100"
                                                            value="{{ \App\Models\VoteSecuritySetting::getSettings()->max_votes_per_ip_daily }}"
                                                            placeholder=" " :popover="'Maximum votes allowed per IP address per day (recommended: 2)'"
                                                            required/>
                            <x-hrace009::label for="max_votes_per_ip_daily">Max Votes Per IP Daily</x-hrace009::label>
                        </div>
                        
                        <div class="relative z-0 mb-6 w-full group">
                            <div id="bypass_in_test_mode_switch" class="flex ml-12">
                                <div class="pretty p-switch">
                                    <input type="checkbox" id="bypass_in_test_mode" name="bypass_in_test_mode"
                                           value="1"
                                           @if( \App\Models\VoteSecuritySetting::getSettings()->bypass_in_test_mode ) checked @endif
                                        @popper(Bypass all security checks when test mode is enabled above)
                                    />
                                    <div class="state p-info">
                                        <label for="bypass_in_test_mode">
                                            {{ \App\Models\VoteSecuritySetting::getSettings()->bypass_in_test_mode ? __('donate.on') : __('donate.off') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <x-hrace009::label for="bypass_in_test_mode_switch">Bypass Security in Test Mode</x-hrace009::label>
                        </div>
                        
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-2">
                            <strong>Note:</strong> IP limits help prevent vote abuse by limiting how many times a single IP can vote per day.
                        </p>
                    </div>
                @endif
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>
