@section('title', ' - ' . __('service.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('service.config') }}</h1>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-2xl mx-auto mt-6">
            <h2 class="mb-6">{{ __('service.teleport_character') }}</h2>
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
            <form action="{{ route('admin.service.updateSettings') }}" method="post">
                {!! csrf_field() !!}
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input id="teleport_world_tag" name="teleport_world_tag"
                                       value="{{ config('pw-config.teleport_world_tag') }}"
                                       placeholder=" " required/>
                    <x-hrace009::label
                        for="teleport_world_tag">{{ __('service.teleport_world_tag') }}</x-hrace009::label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input id="teleport_x" name="teleport_x"
                                       value="{{ config('pw-config.teleport_x') }}"
                                       placeholder=" " required/>
                    <x-hrace009::label for="teleport_x">{{ __('service.teleport_x') }}</x-hrace009::label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input id="teleport_y" name="teleport_y"
                                       value="{{ config('pw-config.teleport_y') }}"
                                       placeholder=" " required/>
                    <x-hrace009::label for="teleport_y">{{ __('service.teleport_y') }}</x-hrace009::label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input id="teleport_z" name="teleport_z"
                                       value="{{ config('pw-config.teleport_z') }}"
                                       placeholder=" " required/>
                    <x-hrace009::label for="teleport_z">{{ __('service.teleport_z') }}</x-hrace009::label>
                </div>
                <h2 class="mb-6">{{ __('service.level_up') }}</h2>
                <div class="relative z-0 mb-6 w-full group">
                    <x-hrace009::input id="level_up_cap" name="level_up_cap"
                                       value="{{ config('pw-config.level_up_cap') }}"
                                       placeholder=" " required/>
                    <x-hrace009::label for="level_up_cap">{{ __('service.level_up_cap') }}</x-hrace009::label>
                </div>
                
                <h2 class="mb-6">{{ __('service.virtual_to_cubi') ?? 'Virtual to Cubi Configuration' }}</h2>
                <div class="relative z-0 mb-6 w-full group">
                    <select id="cubi_transfer_method" name="cubi_transfer_method" 
                            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="transfer" {{ config('pw-config.cubi_transfer_method', 'transfer') == 'transfer' ? 'selected' : '' }}>
                            Transfer Table (Default - uses pwp_transfer table)
                        </option>
                        <option value="direct" {{ config('pw-config.cubi_transfer_method') == 'direct' ? 'selected' : '' }}>
                            Direct (uses usecash stored procedure)
                        </option>
                        <option value="auto" {{ config('pw-config.cubi_transfer_method') == 'auto' ? 'selected' : '' }}>
                            Auto (tries both methods)
                        </option>
                    </select>
                    <x-hrace009::label for="cubi_transfer_method">Cubi Transfer Method</x-hrace009::label>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    <p><strong>Transfer Table:</strong> Uses pwp_transfer table and requires cron job running 'php artisan pw:update-transfer'</p>
                    <p><strong>Direct:</strong> Calls usecash stored procedure directly (immediate)</p>
                    <p><strong>Auto:</strong> Tries transfer method first, then direct if it fails (best compatibility)</p>
                </div>
                <x-hrace009::button-with-popover class="w-auto" popover="{{ __('general.config_save_desc') }}">
                    {{ __('general.Save') }}
                </x-hrace009::button-with-popover>
            </form>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>
