<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('pw-config.server_name', 'Laravel') }} @yield('title')</title>

    @if( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('img/logo/logo.png') }}"
        />
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset(config('pw-config.logo')) }}"
        />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"
        />
    @endif

    <x-hrace009::front.top-script/>

    @php
        $userTheme = auth()->user()->theme ?? config('themes.default');
        $themeConfig = config('themes.themes.' . $userTheme);
    @endphp
    
    @if($themeConfig && isset($themeConfig['css']))
        <link rel="stylesheet" href="{{ asset($themeConfig['css']) }}">
    @endif
    
    <style>
        /* User Dashboard Header Styles */
        .user-header {
            background: linear-gradient(135deg, #1a1a3a 0%, #2a2a4a 100%);
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #6366f1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        .user-header .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }
        
        .user-header-logo {
            max-height: 80px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5));
            transition: transform 0.3s ease;
        }
        
        .user-header-logo:hover {
            transform: scale(1.05);
        }
        
        .user-badge-logo {
            max-height: 50px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5));
        }
        
        @media (max-width: 768px) {
            .user-header {
                padding: 15px 0;
            }
            
            .user-header .header-content {
                gap: 20px;
            }
            
            .user-header-logo {
                max-height: 60px;
            }
            
            .user-badge-logo {
                max-height: 40px;
            }
        }
    </style>
</head>
<body class="antialiased theme-{{ $userTheme }}">
<x-hrace009::front.big-frame>
    <x-hrace009::loading>
        {{ __('general.loading') }}
    </x-hrace009::loading>

    <!-- Sidebar -->
    <x-hrace009::side-bar>
        <x-slot name="links">
            <x-hrace009::front.dashboard-link/>
            @if( config('pw-config.system.apps.shop') )
                <x-hrace009::front.shop-link/>
            @endif

            @if( config('pw-config.system.apps.donate') )
                <x-hrace009::front.donate-link/>
            @endif

            @if( config('pw-config.system.apps.vote') )
                <x-hrace009::front.vote-link/>
            @endif

            @if( config('pw-config.system.apps.voucher') )
                <x-hrace009::front.voucher-link/>
            @endif

            @if ( config('pw-config.system.apps.inGameService') )
                <x-hrace009::front.services-link/>
            @endif

            @if( config('pw-config.system.apps.ranking') )
                <x-hrace009::front.ranking-link/>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-hrace009::side-bar-footer/>
        </x-slot>
    </x-hrace009::side-bar>

    <div class="flex flex-col flex-1 h-full overflow-x-hidden overflow-y-auto">
        {{-- Header Section --}}
        @php
            $headerSettings = \App\Models\HeaderSetting::first();
            $headerLogo = $headerSettings && $headerSettings->header_logo ? $headerSettings->header_logo : config('pw-config.header_logo', 'img/logo/haven_perfect_world_logo.svg');
            $badgeLogo = $headerSettings && $headerSettings->badge_logo ? $headerSettings->badge_logo : config('pw-config.badge_logo', 'img/logo/crucifix_logo.svg');
        @endphp
        <header class="user-header">
            <div class="header-content">
                <img src="{{ asset($headerLogo) }}" alt="{{ config('pw-config.server_name') }}" class="user-header-logo" onclick="window.location.href='{{ route('HOME') }}'" style="cursor: pointer;">
                <img src="{{ asset($badgeLogo) }}" alt="Badge" class="user-badge-logo">
            </div>
        </header>
        
        <x-hrace009::nav-bar>
            <x-slot name="navmenu">
                <x-hrace009::mobile-menu-button/>
                <x-hrace009::brand>
                    <x-slot name="brand">
                        {{ config('pw-config.server_name') }}
                    </x-slot>
                </x-hrace009::brand>
                <x-hrace009::mobile-sub-menu-button/>
                <x-hrace009::desktop-right-button>
                    <x-slot name="button">
                        @livewire('theme-selector')
                        <x-hrace009::dark-theme-button/>
                        <x-hrace009::language-button/>
                        <x-hrace009::character-selector/>
                        <x-hrace009::balance/>
                        <x-hrace009::admin-button/>
                        <x-hrace009::gm-button/>
                        <x-hrace009::site-button/>
                        <x-hrace009::user-avatar/>
                    </x-slot>
                </x-hrace009::desktop-right-button>
                <x-hrace009.mobile-sub-menu>
                    <x-slot name="button">
                        @livewire('theme-selector')
                        <x-hrace009::dark-theme-button/>
                        <x-hrace009::mobile-language-menu/>
                        <x-hrace009::character-selector/>
                        <x-hrace009::admin-button/>
                        <x-hrace009::site-button/>
                        <x-hrace009::mobile-user-avatar/>
                    </x-slot>
                </x-hrace009.mobile-sub-menu>
            </x-slot>
            <x-slot name="navMobilMenu">
                <x-hrace009.mobile-main-menu>
                    <x-slot name="links">
                        <x-hrace009::front.dashboard-link/>
                        @if( config('pw-config.system.apps.shop') )
                            <x-hrace009::front.shop-link/>
                        @endif

                        @if( config('pw-config.system.apps.donate') )
                            <x-hrace009::front.donate-link/>
                        @endif

                        @if( config('pw-config.system.apps.vote') )
                            <x-hrace009::front.vote-link/>
                        @endif

                        @if( config('pw-config.system.apps.voucher') )
                            <x-hrace009::front.voucher-link/>
                        @endif

                        @if ( config('pw-config.system.apps.inGameService') )
                            <x-hrace009::front.services-link/>
                        @endif

                        @if( config('pw-config.system.apps.ranking') )
                            <x-hrace009::front.ranking-link/>
                        @endif
                    </x-slot>
                </x-hrace009.mobile-main-menu>
            </x-slot>
        </x-hrace009::nav-bar>

        <!-- Main content -->
        <main class="flex-1">

            <!-- Content header -->
            @if (isset($header))
            {{ $header }}
        @endif
        <!-- Content -->
            <div class="mt-2 pb-16">
                <div class="max-w mx-6 my-6">
                    <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="col-span-3">
                            {{ $content }}
                        </div>
                        <div>
                            <x-hrace009::front.widget/>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <x-hrace009::portal.footer/>
    </div>
    <!-- Panels -->
    <x-hrace009::settings-panel/>
</x-hrace009::front.big-frame>
@yield('footer')
<x-hrace009::front.bottom-script/>
</body>
</html>
