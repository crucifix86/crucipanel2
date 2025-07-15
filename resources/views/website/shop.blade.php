@extends('layouts.website')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.shop'))

@section('styles')
    <style>
        /* Shop page specific overrides */
        .container {
            max-width: 1000px;
        }

        /* Additional shop-specific styles not in theme */
        .balance-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .balance-icon {
            font-size: 1.3rem;
        }

        .balance-label {
            color: #b19cd9;
            font-weight: 600;
        }

        .item-description {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 20px;
            line-height: 1.4;
            min-height: 40px;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(45deg, #ff6b6b, #dc3545);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .bonus-button {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .bonus-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
        }

        .selected-character, .no-character {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .char-icon {
            font-size: 1.3rem;
        }

        .char-label {
            color: #b19cd9;
            font-weight: 600;
        }

        .char-name {
            color: #dda0dd;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .change-char, .select-char {
            color: #9370db;
            text-decoration: none;
            padding: 5px 15px;
            border: 1px solid rgba(147, 112, 219, 0.5);
            border-radius: 15px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .change-char:hover, .select-char:hover {
            background: rgba(147, 112, 219, 0.2);
            border-color: #9370db;
            color: #dda0dd;
        }

        .warning {
            color: #ff6b6b;
            font-weight: 600;
        }

        .char-dropdown h4 {
            color: #9370db;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .char-option .char-name {
            font-weight: 600;
        }

        .no-chars {
            color: #b19cd9;
            text-align: center;
            padding: 20px;
        }

        .user-balance {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .user-info-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .user-balance {
                flex-direction: column;
                gap: 15px;
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

    <div class="shop-section">
        <h2 class="section-title">Mystical Shop</h2>
        
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
                        <span class="balance-label">{{ __('site.shop.balance.coins', ['name' => config('pw-config.currency_name', 'Coins')]) }}</span>
                        <span class="balance-value">{{ number_format(Auth::user()->money, 0, '', '.') }}</span>
                    </div>
                    <div class="balance-item">
                        <span class="balance-icon">⭐</span>
                        <span class="balance-label">{{ __('site.shop.balance.bonus_points') }}</span>
                        <span class="balance-value">{{ number_format(Auth::user()->bonuses, 0, '', '.') }}</span>
                    </div>
                </div>
                
                <div class="character-selector">
                    @if(Auth::user()->characterId())
                        <div class="selected-character">
                            <span class="char-icon">👤</span>
                            <span class="char-label">{{ __('site.shop.character.label') }}</span>
                            <span class="char-name">{{ Auth::user()->characterName() }}</span>
                            <a href="#" class="change-char" onclick="toggleCharSelect(event)">{{ __('site.shop.character.change') }}</a>
                        </div>
                    @else
                        <div class="no-character">
                            <span class="char-icon">⚠️</span>
                            <span class="warning">{{ __('site.shop.character.no_character') }}</span>
                            <a href="#" class="select-char" onclick="toggleCharSelect(event)">{{ __('site.shop.character.select') }}</a>
                        </div>
                    @endif
                    
                    <!-- Character Selection Dropdown -->
                    <div class="char-dropdown" id="charDropdown" style="display: none;">
                        <h4>{{ __('site.shop.character.select') }}</h4>
                        @php
                            $api = new \hrace009\PerfectWorldAPI\API;
                        @endphp
                        
                        @if($api->online)
                            @php
                                $roles = Auth::user()->roles();
                            @endphp
                            
                            @if(count($roles) > 0)
                                @foreach($roles as $role)
                                    <a href="{{ url('character/select/' . $role['id']) }}" class="char-option">
                                        <span class="char-name">{{ $role['name'] }}</span>
                                    </a>
                                @endforeach
                            @else
                                <p class="no-chars">{{ __('site.shop.character.no_characters') }}</p>
                            @endif
                        @else
                            <p class="no-chars">{{ __('site.shop.character.server_offline') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endauth
        
        <!-- Shop Items -->
        <div class="shop-grid">
            @if($tab === 'items')
                @php
                    $items = \App\Models\Shop::orderBy('id', 'desc')->limit(20)->get();
                @endphp
                @forelse($items as $item)
                    <div class="shop-item">
                        @if($item->discount > 0)
                            <div class="discount-badge">-{{ $item->discount }}%</div>
                        @endif
                        
                        <div class="item-icon">
                            @if($item->mask == 2)
                                👘
                            @elseif($item->mask == 4)
                                👗
                            @elseif($item->mask == 8)
                                🐴
                            @elseif($item->mask == 131072)
                                ⚔️
                            @else
                                📦
                            @endif
                        </div>
                        
                        <h3 class="item-name">{{ $item->name }}</h3>
                        <p class="item-description">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="item-price">
                            @if($item->discount > 0)
                                <div class="original-price" style="text-decoration: line-through; color: #b19cd9; font-size: 0.9rem;">
                                    {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                                </div>
                                {{ number_format($item->price * (1 - $item->discount/100)) }} {{ config('pw-config.currency_name', 'Points') }}
                            @else
                                {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.shop.purchase.post', $item->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    <button type="submit" class="purchase-button">{{ __('site.shop.items.purchase') }}</button>
                                </form>
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">{{ __('site.shop.character.select_to_purchase') }}</p>
                            @endif
                        @endauth
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px;">
                        <span style="font-size: 4rem; display: block; margin-bottom: 20px;">📦</span>
                        <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">{{ __('site.shop.items.no_items') }}</p>
                        <p style="color: #b19cd9;">{{ __('site.shop.items.check_back') }}</p>
                    </div>
                @endforelse
            @endif
        </div>
        
        @guest
        <div style="text-align: center; color: #b19cd9; font-size: 1.1rem; margin-top: 20px;">
            <p>Please <a href="{{ route('login') }}" style="color: #9370db; text-decoration: none; font-weight: 600;">login</a> to access the shop</p>
        </div>
        @endguest
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
        // Toggle character dropdown
        function toggleCharSelect(event) {
            event.preventDefault();
            const dropdown = document.getElementById('charDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('charDropdown');
            const selector = document.querySelector('.character-selector');
            if (dropdown && !selector.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
@endsection