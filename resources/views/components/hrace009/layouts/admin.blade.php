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
        /* Admin Header Styles */
        .admin-header {
            background: linear-gradient(135deg, #1a1a3a 0%, #2a2a4a 100%);
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #6366f1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        .admin-header .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }
        
        .admin-header-logo {
            max-height: 80px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5));
            transition: transform 0.3s ease;
        }
        
        .admin-header-logo:hover {
            transform: scale(1.05);
        }
        
        .admin-badge-logo {
            max-height: 50px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5));
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 15px 0;
            }
            
            .admin-header .header-content {
                gap: 20px;
            }
            
            .admin-header-logo {
                max-height: 60px;
            }
            
            .admin-badge-logo {
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
            <x-hrace009::admin.dashboard-link/>
            <x-hrace009::admin.system-link/>
            <x-hrace009::admin.theme-link/>
            <x-hrace009::admin.members-link/>
            <x-hrace009::admin.mass-message-link/>
            <x-hrace009::admin.welcome-message-link/>
            @if( config('pw-config.system.apps.news') )
                <x-hrace009::admin.news-link/>
            @endif
            @if( config('pw-config.system.apps.shop') )
                <x-hrace009::admin.shop-link/>
            @endif
            @if( config('pw-config.system.apps.donate') )
                <x-hrace009::admin.donate-link/>
            @endif
            @if( config('pw-config.system.apps.voucher') )
                <x-hrace009::admin.voucher-link/>
            @endif
            @if( config('pw-config.system.apps.vote') )
                <x-hrace009::admin.vote-link/>
            @endif
            @if( config('pw-config.system.apps.visitReward') )
                <x-hrace009::admin.visit-reward-link/>
            @endif
            @if( config('pw-config.system.apps.inGameService') )
                <x-hrace009::admin.service-link/>
            @endif
            @if( config('pw-config.system.apps.ranking') )
                <x-hrace009::admin.ranking-link/>
            @endif
            <x-hrace009::admin.manage-link/>
            <x-hrace009::admin.messaging-link/>
            <x-hrace009::admin.faction-icons-link/>
            <x-hrace009::admin.pages-link/>
            <x-hrace009::admin.live-chat-link/>
        </x-slot>
        <x-slot name="footer">
            <x-hrace009::side-bar-footer/>
        </x-slot>
    </x-hrace009::side-bar>

    <div class="flex flex-col flex-1 h-full overflow-x-hidden overflow-y-auto">
        {{-- Header Section --}}
        @php
            $headerSettings = \App\Models\HeaderSetting::first();
            $headerContent = $headerSettings ? $headerSettings->content : '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>';
            $headerAlignment = $headerSettings ? $headerSettings->alignment : 'center';
        @endphp
        <header class="admin-header">
            <div class="header-content" style="text-align: {{ $headerAlignment }}; color: #e6d7f0;">
                <a href="{{ route('HOME') }}" style="text-decoration: none; color: inherit;">
                    {!! $headerContent !!}
                </a>
            </div>
        </header>
        
        <x-hrace009::nav-bar>
            <x-slot name="navmenu">
                <x-hrace009::mobile-menu-button/>
                <x-hrace009::admin.brand>
                    <x-slot name="brand">
                        {{ config('pw-config.server_name') }} - Admin
                    </x-slot>
                </x-hrace009::admin.brand>
                <x-hrace009::mobile-sub-menu-button/>
                <x-hrace009::desktop-right-button>
                    <x-slot name="button">
                        @livewire('theme-selector')
                        <x-hrace009::dark-theme-button/>
                        <x-hrace009::language-button/>
                        <x-hrace009::user-button/>
                        <x-hrace009::user-avatar/>
                    </x-slot>
                </x-hrace009::desktop-right-button>
                <x-hrace009.mobile-sub-menu>
                    <x-slot name="button">
                        @livewire('theme-selector')
                        <x-hrace009::dark-theme-button/>
                        <x-hrace009::mobile-language-menu/>
                        <x-hrace009::user-button/>
                        <x-hrace009::admin.mobile-user-avatar/>
                    </x-slot>
                </x-hrace009.mobile-sub-menu>
            </x-slot>
            <x-slot name="navMobilMenu">
                <x-hrace009.mobile-main-menu>
                    <x-slot name="links">
                        <x-hrace009::admin.dashboard-link/>
                        <x-hrace009::admin.system-link/>
                        <x-hrace009::admin.members-link/>
                        <x-hrace009::admin.mass-message-link/>
                        <x-hrace009::admin.welcome-message-link/>
                        <x-hrace009::admin.faction-icons-link/>
                        @if( config('pw-config.system.apps.news') )
                            <x-hrace009::admin.news-link/>
                        @endif
                        @if( config('pw-config.system.apps.shop') )
                            <x-hrace009::admin.shop-link/>
                        @endif
                        @if( config('pw-config.system.apps.donate') )
                            <x-hrace009::admin.donate-link/>
                        @endif
                        @if( config('pw-config.system.apps.voucher') )
                            <x-hrace009::admin.voucher-link/>
                        @endif
                        @if( config('pw-config.system.apps.vote') )
                            <x-hrace009::admin.vote-link/>
                        @endif
                        @if( config('pw-config.system.apps.visitReward') )
                            <x-hrace009::admin.visit-reward-link/>
                        @endif
                        @if( config('pw-config.system.apps.inGameService') )
                            <x-hrace009::admin.service-link/>
                        @endif
                        @if( config('pw-config.system.apps.ranking') )
                            <x-hrace009::admin.ranking-link/>
                        @endif
                        <x-hrace009::admin.manage-link/>
                        <x-hrace009::admin.pages-link/>
                        <x-hrace009::admin.live-chat-link/>
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
                {{ $content }}
            </div>
        </main>
        <x-hrace009::footer/>
    </div>
    <!-- Panels -->
    <x-hrace009::settings-panel/>
</x-hrace009::front.big-frame>
@yield('footer')
<x-hrace009::front.bottom-script/>
<x-hrace009::flash-message/>
@stack('scripts')
</body>
</html>
