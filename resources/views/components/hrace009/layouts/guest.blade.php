<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

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

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/portal/bootstrap/dist/css/bootstrap.min.css') }}" />
    <!-- FontAwesome for icons -->
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fontawesome-all.min.js') }}"></script>
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fa-v4-shims.min.js') }}"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom-home.css') }}">

    @php
        $userTheme = auth()->check() ? auth()->user()->theme : config('themes.default');
        $themeConfig = config('themes.themes.' . $userTheme);
    @endphp
    
    @if($themeConfig && isset($themeConfig['css']))
        <link rel="stylesheet" href="{{ asset($themeConfig['css']) }}">
    @endif

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="antialiased theme-{{ $userTheme }}">
<x-hrace009::auth.general-frame>
    <!-- Loading screen -->
    <x-hrace009::loading>{{ __('general.loading') }}</x-hrace009::loading>
    <x-hrace009::auth.dark-frame>
        <!-- Brand -->
        <x-hrace009::auth.brand>
            <x-slot name="logo">
                <x-hrace009::logo/>
            </x-slot>
            {{ config('app.name') }}
        </x-hrace009::auth.brand>
        <main>
            <x-hrace009::auth.inside-main>
                {{ $slot }}
            </x-hrace009::auth.inside-main>
        </main>
    </x-hrace009::auth.dark-frame>
    <!-- Toggle dark mode button -->
    <x-hrace009::dark-mode/>
</x-hrace009::auth.general-frame>
<x-hrace009::auth.script/>

<!-- Scripts -->
<script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Livewire Scripts -->
@livewireScripts
</body>
</html>
