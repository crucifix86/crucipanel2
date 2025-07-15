@extends('layouts.website')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.shop'))

@section('styles')
    <style>
        /* Shop specific styles */
        .shop-tabs {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .shop-tab {
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--border-color);
            background: var(--surface-color);
            color: var(--text-color);
        }
        
        .shop-tab:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .shop-tab.active {
            background: var(--button-gradient);
            color: white;
            border-color: var(--primary-color);
        }
        
        .user-info-bar {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .user-balance {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .balance-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .balance-icon {
            font-size: 1.5rem;
        }
        
        .balance-label {
            font-size: 0.9rem;
            color: var(--accent-color);
        }
        
        .balance-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .shop-item {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .shop-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .item-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 15px;
        }
        
        .item-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 10px;
        }
        
        .item-description {
            color: var(--accent-color);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .item-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .price-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .buy-button {
            width: 100%;
            padding: 10px;
            background: var(--button-gradient);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .buy-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--particle-shadow);
        }
        
        .buy-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .character-select {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.4);
            color: var(--text-color);
            margin-bottom: 10px;
        }
        
        .no-items {
            text-align: center;
            color: var(--accent-color);
            font-size: 1.2rem;
            margin: 50px 0;
        }
        
        @media (max-width: 768px) {
            .shop-tabs {
                flex-direction: column;
                gap: 10px;
            }
            
            .user-balance {
                flex-direction: column;
                gap: 15px;
            }
            
            .shop-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $api = new \hrace009\PerfectWorldAPI\API();
        $point = new \App\Models\Point();
        $onlinePlayer = $point->getOnlinePlayer();
        $onlineCount = $api->online ? ($onlinePlayer >= 100 ? $onlinePlayer + config('pw-config.fakeonline', 0) : $onlinePlayer) : 0;
        $tab = request()->get('tab', 'items');
    @endphp
    
    <!-- Server Status -->
    <div class="server-status" style="position: fixed; top: 20px; left: 20px; z-index: 100; padding: 10px 15px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); width: 220px;">
        <div class="status-indicator {{ $api->online ? 'online' : 'offline' }}">
            <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; animation: pulse 2s infinite; {{ $api->online ? 'background: #10b981; box-shadow: 0 0 10px #10b981;' : 'background: #ef4444; box-shadow: 0 0 10px #ef4444;' }}"></span>
            <span class="status-text" style="margin-left: 8px; font-weight: 600;">Server {{ $api->online ? 'Online' : 'Offline' }}</span>
        </div>
        @if($api->online)
            <div class="players-online" style="margin-top: 5px; font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-users"></i> {{ $onlineCount }} {{ $onlineCount == 1 ? 'Player' : 'Players' }} Online
            </div>
        @endif
    </div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    @php
        $headerSettings = \App\Models\HeaderSetting::first();
        $headerContent = $headerSettings ? $headerSettings->content : '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>';
        $headerAlignment = $headerSettings ? $headerSettings->alignment : 'center';
    @endphp
    
    <div class="header header-{{ $headerAlignment }}">
        <div class="mystical-border"></div>
        <a href="{{ route('HOME') }}" style="text-decoration: none; color: inherit;">
            {!! $headerContent !!}
        </a>
    </div>

    <nav class="nav-bar">
        <div class="nav-links">
            <a href="{{ route('HOME') }}" class="nav-link {{ Route::is('HOME') ? 'active' : '' }}">{{ __('site.nav.home') }}</a>
            
            @if( config('pw-config.system.apps.shop') )
            <a href="{{ route('public.shop') }}" class="nav-link {{ Route::is('public.shop') ? 'active' : '' }}">{{ __('site.nav.shop') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.donate') )
            <a href="{{ route('public.donate') }}" class="nav-link {{ Route::is('public.donate') ? 'active' : '' }}">{{ __('site.nav.donate') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.ranking') )
            <a href="{{ route('public.rankings') }}" class="nav-link {{ Route::is('public.rankings') ? 'active' : '' }}">{{ __('site.nav.rankings') }}</a>
            @endif
            
            @if( config('pw-config.system.apps.vote') )
            <a href="{{ route('public.vote') }}" class="nav-link {{ Route::is('public.vote') ? 'active' : '' }}">{{ __('site.nav.vote') }}</a>
            @endif
            
            @php
                $pages = \App\Models\Page::where('active', true)->orderBy('title')->get();
            @endphp
            @if($pages->count() > 0)
                <div class="nav-dropdown">
                    <a href="#" class="nav-link dropdown-toggle" onclick="event.preventDefault(); this.parentElement.classList.toggle('active');">
                        {{ __('site.nav.pages') }} <span class="dropdown-arrow">▼</span>
                    </a>
                    <div class="dropdown-menu">
                        @foreach($pages as $page)
                            <a href="{{ route('page.show', $page->slug) }}" class="dropdown-item">{{ $page->title }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <a href="{{ route('public.members') }}" class="nav-link {{ Route::is('public.members') ? 'active' : '' }}">{{ __('site.nav.members') }}</a>
        </div>
    </nav>

    <!-- Shop Content -->
    <div class="content-section">
        <h2 class="page-title" style="position: relative; z-index: 1; color: var(--primary-color); text-align: center; margin-bottom: 30px;">{{ __('site.shop.title') }}</h2>
        
        <!-- Shop Tabs -->
        <div class="shop-tabs">
            <a href="{{ route('public.shop', ['tab' => 'items']) }}" 
               class="shop-tab {{ $tab === 'items' ? 'active' : '' }}">
                <span style="margin-right: 8px;">📦</span> {{ __('site.shop.tabs.items') }}
            </a>
            <a href="{{ route('public.shop', ['tab' => 'vouchers']) }}" 
               class="shop-tab {{ $tab === 'vouchers' ? 'active' : '' }}">
                <span style="margin-right: 8px;">🎟️</span> {{ __('site.shop.tabs.vouchers') }}
            </a>
            <a href="{{ route('public.shop', ['tab' => 'services']) }}" 
               class="shop-tab {{ $tab === 'services' ? 'active' : '' }}">
                <span style="margin-right: 8px;">⚡</span> {{ __('site.shop.tabs.services') }}
            </a>
        </div>
        
        @auth
            <!-- User Info Bar -->
            <div class="user-info-bar">
                <div class="user-balance">
                    <div class="balance-item">
                        <span class="balance-icon">💰</span>
                        <div>
                            <div class="balance-label">{{ __('site.shop.balance.gold') }}</div>
                            <div class="balance-value">{{ number_format(Auth::user()->money ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="balance-item">
                        <span class="balance-icon">🎖️</span>
                        <div>
                            <div class="balance-label">{{ __('site.shop.balance.bonus') }}</div>
                            <div class="balance-value">{{ number_format(Auth::user()->bonuses ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="user-info-bar">
                <div style="text-align: center; color: var(--accent-color);">
                    <i class="fas fa-lock" style="margin-right: 10px;"></i>
                    {{ __('site.shop.login_required') }}
                    <a href="{{ route('login') }}" style="color: var(--primary-color); margin-left: 10px;">{{ __('site.login.login_button') }}</a>
                </div>
            </div>
        @endauth
        
        <!-- Shop Items -->
        <div class="shop-grid">
            @if($tab === 'items')
                @php
                    $items = \App\Models\Shop::where('active', true)->where('type', 'item')->get();
                @endphp
                @forelse($items as $item)
                    <div class="shop-item">
                        <div class="item-icon">
                            📦
                        </div>
                        <div class="item-name">{{ $item->name }}</div>
                        <div class="item-description">{{ $item->description }}</div>
                        <div class="item-price">
                            <span class="price-value">{{ number_format($item->price) }} {{ $item->currency }}</span>
                        </div>
                        @auth
                            <select class="character-select" id="character-{{ $item->id }}">
                                <option value="">{{ __('site.shop.select_character') }}</option>
                                @foreach(Auth::user()->characters ?? [] as $character)
                                    <option value="{{ $character->id }}">{{ $character->name }}</option>
                                @endforeach
                            </select>
                            <button class="buy-button" onclick="buyItem({{ $item->id }})">
                                {{ __('site.shop.buy_now') }}
                            </button>
                        @else
                            <button class="buy-button" disabled>
                                {{ __('site.shop.login_required') }}
                            </button>
                        @endauth
                    </div>
                @empty
                    <div class="no-items">
                        {{ __('site.shop.no_items') }}
                    </div>
                @endforelse
            @endif
        </div>
    </div>

    @php
        $footerSettings = \App\Models\FooterSetting::first();
        $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
        $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Enhance your journey with mystical items</p>';
        $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
        $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
    @endphp
    <div class="footer footer-{{ $footerAlignment }}">
        <div class="footer-container">
            <div class="footer-content-section">
                {!! $footerContent !!}
                <p class="footer-text">{!! $footerCopyright !!}</p>
            </div>
            
            @if($socialLinks->count() > 0)
            <div class="social-links">
                @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener noreferrer" title="{{ $link->platform }}">
                        <i class="{{ $link->icon }}"></i>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function buyItem(itemId) {
            const characterSelect = document.getElementById('character-' + itemId);
            const characterId = characterSelect.value;
            
            if (!characterId) {
                alert('{{ __("site.shop.select_character") }}');
                return;
            }
            
            // Add your buy item logic here
            console.log('Buying item', itemId, 'for character', characterId);
        }
    </script>
@endsection