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

    <!-- Mystical Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/mystical-purple-unified.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Admin-specific overrides for mystical theme */
        .admin-content {
            position: relative;
            z-index: 3;
            max-width: 1200px;
            margin-left: 280px;
            margin-right: auto;
            padding: 20px;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .admin-content {
                margin-left: 0;
                max-width: 100%;
                padding: 15px;
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
            <x-hrace009::admin.members-link/>
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
        <x-slot name="footer">
            <x-hrace009::side-bar-footer/>
        </x-slot>
    </x-hrace009::side-bar>

    <div class="flex flex-col flex-1 h-full overflow-x-hidden overflow-y-auto">
        {{-- Mystical Header Section --}}
        @php
            $headerSettings = \App\Models\HeaderSetting::first();
            $headerContent = $headerSettings ? $headerSettings->content : '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>';
            $headerAlignment = $headerSettings ? $headerSettings->alignment : 'center';
        @endphp
        
        <div class="mystical-bg"></div>
        <div class="floating-particles"></div>
        <div class="dragon-ornament dragon-left">🐉</div>
        <div class="dragon-ornament dragon-right">🐉</div>
        
        <div class="admin-content">
            <div class="header header-{{ $headerAlignment }}">
                <div class="mystical-border"></div>
                <a href="{{ route('HOME') }}" style="text-decoration: none; color: inherit;">
                    {!! $headerContent !!}
                </a>
            </div>
        
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
            
            <!-- Admin Content -->
            <div class="content-section">
                {{ $content }}
            </div>
            
            <!-- Mystical Footer -->
            @php
                $footerSettings = \App\Models\FooterSetting::first();
                $footerContent = $footerSettings ? $footerSettings->content : 'Copyright © 2025 Haven Perfect World. All rights reserved.';
                $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
                $socialLinks = $footerSettings ? $footerSettings->social_links : [];
            @endphp
            
            <div class="footer footer-{{ $footerAlignment }}">
                <div class="footer-text">
                    {!! $footerContent !!}
                </div>
                
                @if(!empty($socialLinks))
                <div class="social-links">
                    @foreach($socialLinks as $social)
                        <a href="{{ $social['url'] }}" target="_blank" class="social-link">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div> <!-- End admin-content -->
        </main>
    </div>
    <!-- Panels -->
    <x-hrace009::settings-panel/>
</x-hrace009::front.big-frame>
@yield('footer')
<x-hrace009::front.bottom-script/>
<x-hrace009::flash-message/>

<!-- Mystical Theme JavaScript -->
<script src="{{ asset('js/mystical-purple-unified.js') }}"></script>

@stack('scripts')
</body>
</html>
