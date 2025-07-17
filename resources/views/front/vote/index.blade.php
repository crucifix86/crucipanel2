@section('title', ' - ' . __('vote.title'))
<x-hrace009.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('general.menu.vote') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        @if( config('arena.test_mode') || config('arena.test_mode_clear_timer') )
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-600 rounded-lg">
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                    ⚠️ ARENA TEST MODE ACTIVE
                </h3>
                <p class="text-sm text-red-700 dark:text-red-300">
                    @if( config('arena.test_mode') )
                        • Callbacks will always return successful vote<br>
                    @endif
                    @if( config('arena.test_mode_clear_timer') )
                        • Vote cooldown timer is disabled<br>
                    @endif
                    <strong>Remember to disable test mode in production!</strong>
                </p>
                @if( auth()->user()->permission && auth()->user()->permission->is_admin )
                    <div class="mt-3">
                        <form action="{{ route('app.vote.arena.clearLogs') }}" method="post" class="inline">
                            {{ csrf_field() }}
                            <button type="submit" class="px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded">
                                Clear My Arena Logs (Testing)
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endif
        @if( config('arena.status') === true )
            <div class="mb-4">
                <div
                    class="flex flex-row justify-between py-2 px-4 w-full bg-gray-200 border-gray-400 dark:bg-darker dark:border-primary border rounded rounded-b-none">
                    <span class="dark:text-primary-light">Arena Top 100</span>
                    <span
                        class="flex flex-row px-3 py-1 justify-between items-center text-sm font-bold text-gray-100 transition-colors duration-200 transform rounded cursor-pointer {{ $arena->color(config('arena.reward_type')) }}">
                        @if( config('arena.reward_type') === 'cubi' )
                            {{ config('arena.reward') }}
                            {{ __('vote.create.type_cubi') }}
                        @endif
                        @if( config('arena.reward_type') === 'virtual' )
                            {{ config('arena.reward') }}
                            {{ __('vote.create.type_virtual', ['currency' => config('pw-config.currency_name')]) }}
                        @endif
                        @if( config('arena.reward_type') === 'bonusess' )
                            {{ config('arena.reward') }}
                            {{ __('vote.create.type_bonusess') }}
                        @endif
                        </span>
                </div>
                <div
                    class="flex flex-row justify-center p-4 w-full bg-gray-200 border-gray-400 dark:bg-darker dark:border-primary border-l border-r border-b rounded-b">
                    @if( $arena_info[ Auth::user()->ID ]['status'] )
                        <form action="{{ route('app.vote.arena.submit' )  }}" method="post">
                            {{ csrf_field() }}
                            <x-hrace009::button type="submit">
                                {{ __('vote.button', [ 'name' => 'Arena Top 100' ]) }}
                            </x-hrace009::button>
                        </form>
                    @else
                        <div class="text-center">
                            <span>{{ __('vote.cooldown') }}</span>
                            <div data-countdown="{{ $arena_info[ Auth::user()->ID ]['end_time'] }}"></div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @if( count( $sites ) === 0 )
            @if( ! config('arena.status') === true )
                <div
                    class="flex flex-row z-0 p-4 w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"
                    role="alert"
                >
                    <span class="block sm:inline">{!! __('vote.no_sites') !!}</span>
                </div>
            @endif
        @else
            @foreach( $sites as $site )
                <div class="mb-4">
                    <div
                        class="flex flex-row justify-between py-2 px-4 w-full bg-gray-200 border-gray-400 dark:bg-darker dark:border-primary border rounded rounded-b-none">
                        <span class="dark:text-primary-light">{{ $site->name }}</span>
                        <span
                            class="flex flex-row px-3 py-1 justify-between items-center text-sm font-bold text-gray-100 transition-colors duration-200 transform rounded cursor-pointer {{ $site->color($site->type) }}">{{ $site->type === 'cubi' ? __('vote.create.type_cubi') : __('vote.create.type_virtual', ['currency' => config('pw-config.currency_name')]) }}
                        </span>
                    </div>
                    <div
                        class="flex flex-row justify-center p-4 w-full bg-gray-200 border-gray-400 dark:bg-darker dark:border-primary border-l border-r border-b rounded-b">
                        @if( $vote_info[ $site->id ]['status'] )
                            <form action="{{ route('app.vote.check', $site->id )  }}" method="post">
                                {{ csrf_field() }}
                                <x-hrace009::button type="submit">
                                    {{ __('vote.button', [ 'name' => $site->name ]) }}
                                </x-hrace009::button>
                            </form>
                        @else
                            <div class="text-center">
                                <span>{{ __('vote.cooldown') }}</span>
                                <div data-countdown="{{ $vote_info[ $site->id ]['end_time'] }}"></div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </x-slot>
</x-hrace009.layouts.app>
