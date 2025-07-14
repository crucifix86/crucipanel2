@extends('layouts.admin')

@section('content')
    <div class="space-y-4 mt-3">
        <h2 class="text-xl font-semibold dark:text-gray-300">{{ __('Vote Security Settings') }}</h2>
        
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

        <form action="{{ route('admin.vote.security.post') }}" method="post">
            @csrf
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
                
                <!-- IP-Based Limits Section -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">IP-Based Vote Limits</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="ip_limit_enabled" id="ip_limit_enabled" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   @if($settings->ip_limit_enabled) checked @endif>
                            <label for="ip_limit_enabled" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable IP-based vote limiting
                            </label>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="max_votes_per_ip_daily" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Maximum votes per IP per day
                                </label>
                                <input type="number" name="max_votes_per_ip_daily" id="max_votes_per_ip_daily" 
                                       value="{{ $settings->max_votes_per_ip_daily }}"
                                       min="1" max="100"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Recommended: 2 (matches Arena Top 100 limit)
                                </p>
                            </div>
                            
                            <div>
                                <label for="max_votes_per_ip_per_site" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Maximum votes per IP per site per day
                                </label>
                                <input type="number" name="max_votes_per_ip_per_site" id="max_votes_per_ip_per_site" 
                                       value="{{ $settings->max_votes_per_ip_per_site }}"
                                       min="1" max="10"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Usually 1 to prevent multiple votes on same site
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Restrictions Section -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Account Restrictions</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="account_restrictions_enabled" id="account_restrictions_enabled" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   @if($settings->account_restrictions_enabled) checked @endif>
                            <label for="account_restrictions_enabled" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Enable account restrictions for voting
                            </label>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="min_account_age_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Minimum account age (days)
                                </label>
                                <input type="number" name="min_account_age_days" id="min_account_age_days" 
                                       value="{{ $settings->min_account_age_days }}"
                                       min="0" max="365"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Set to 0 to disable. Recommended: 7 days
                                </p>
                            </div>
                            
                            <div>
                                <label for="min_character_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Minimum character level
                                </label>
                                <input type="number" name="min_character_level" id="min_character_level" 
                                       value="{{ $settings->min_character_level }}"
                                       min="0" max="150"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Set to 0 to disable level requirement
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="require_email_verified" id="require_email_verified" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   @if($settings->require_email_verified) checked @endif>
                            <label for="require_email_verified" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Require verified email address to vote
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Test Mode Section -->
                <div class="pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Test Mode Settings</h3>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="bypass_in_test_mode" id="bypass_in_test_mode" 
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               @if($settings->bypass_in_test_mode) checked @endif>
                        <label for="bypass_in_test_mode" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Bypass all security restrictions when Arena vote test mode is enabled
                        </label>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        When Arena test mode is active, all IP limits and account restrictions will be ignored to allow testing.
                    </p>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                        {{ __('admin.save') }}
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Information Box -->
        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-2">Security Settings Information</h4>
            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1 list-disc list-inside">
                <li>IP limits prevent vote abuse from the same network/VPN</li>
                <li>Account age requirements stop newly created spam accounts</li>
                <li>Character level requirements ensure players are invested in the game</li>
                <li>Email verification adds another layer of account validation</li>
                <li>All restrictions are bypassed when Arena test mode is active for easier testing</li>
            </ul>
        </div>
    </div>
@endsection