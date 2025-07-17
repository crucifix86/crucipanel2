@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.shop'))

@section('body-class', 'shop-page')

@section('content')
<div class="content-section shop-section">
            <h2 class="section-title">Mystical Shop</h2>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div data-notification class="success-notification">
                <p>
                    <span>✓</span>{{ session('success') }}
                </p>
            </div>
            @endif
            
            @if(session('error'))
            <div data-notification class="error-notification">
                <p>
                    <span>✗</span>{{ session('error') }}
                </p>
            </div>
            @endif
            
            <!-- Search Bar -->
            <div class="search-container">
                <form method="GET" action="{{ route('public.shop') }}" class="search-form">
                    <div class="search-controls">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="{{ __('site.shop.search_placeholder') }}" 
                               class="search-input">
                        <button type="submit" class="search-button">
                            {{ __('site.shop.search_button') }}
                        </button>
                        @if($search)
                            <a href="{{ route('public.shop') }}" class="search-clear">{{ __('site.shop.clear') }}</a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Shop Tabs -->
            <div class="shop-tabs">
                <a href="{{ route('public.shop', ['tab' => 'items']) }}" 
                   class="shop-tab {{ $tab === 'items' ? 'active' : '' }}">
                    <span>📦</span> {{ __('site.shop.tabs.items') }}
                </a>
                <a href="{{ route('public.shop', ['tab' => 'vouchers']) }}" 
                   class="shop-tab {{ $tab === 'vouchers' ? 'active' : '' }}">
                    <span>🎟️</span> {{ __('site.shop.tabs.vouchers') }}
                </a>
                <a href="{{ route('public.shop', ['tab' => 'services']) }}" 
                   class="shop-tab {{ $tab === 'services' ? 'active' : '' }}">
                    <span>⚡</span> {{ __('site.shop.tabs.services') }}
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
                    <div class="char-dropdown" id="charDropdown">
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
            
            <!-- Items Layout with Sidebar -->
            @if($tab === 'items')
            <div class="items-layout">
                <!-- Category Sidebar -->
                <div class="category-sidebar">
                    <div class="category-sidebar-inner">
                        <h3>{{ __('site.shop.categories.title') }}</h3>
                        <div class="category-sidebar-scroll">
                            @foreach($categories as $category)
                                <a href="{{ route('public.shop', ['tab' => 'items', 'mask' => $category['mask']]) }}" 
                                   class="category-sidebar-link {{ $currentMask == $category['mask'] && ($currentMask !== null || $category['mask'] === null) ? 'active' : '' }}">
                                    <span class="category-icon">{{ $category['icon'] }}</span>
                                    <span class="category-name">{{ $category['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Items Display Area -->
                <div class="items-display">
                    @if($items->count() > 0)
                    <div class="shop-grid">
                        @foreach($items as $item)
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
                                <div class="original-price">
                                    {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                                </div>
                                {{ number_format($item->price * (1 - $item->discount/100)) }} {{ config('pw-config.currency_name', 'Points') }}
                            @else
                                {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.shop.purchase.post', $item->id) }}" method="POST" class="purchase-form">
                                    @csrf
                                    <button type="submit" class="purchase-button">{{ __('site.shop.items.purchase') }}</button>
                                </form>
                                
                                @if($item->poin > 0)
                                <form action="{{ route('app.shop.point.post', $item->id) }}" method="POST" class="bonus-form">
                                    @csrf
                                    <button type="submit" class="bonus-button">{{ __('site.shop.items.buy_with_bonus', ['points' => $item->poin]) }}</button>
                                </form>
                                @endif
                            @else
                                <p class="select-character-notice">{{ __('site.shop.character.select_to_purchase') }}</p>
                            @endif
                        @endauth
                    </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination for items -->
                    @if($items->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-wrapper">
                            @if($items->onFirstPage())
                                <span class="pagination-disabled">{{ __('site.shop.pagination.previous') }}</span>
                            @else
                                <a href="{{ $items->previousPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   class="pagination-link">
                                    {{ __('site.shop.pagination.previous') }}
                                </a>
                            @endif
                            
                            <span class="pagination-info">
                                {{ __('site.shop.pagination.page_of', ['current' => $items->currentPage(), 'total' => $items->lastPage()]) }}
                            </span>
                            
                            @if($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   class="pagination-link">
                                    {{ __('site.shop.pagination.next') }}
                                </a>
                            @else
                                <span class="pagination-disabled">{{ __('site.shop.pagination.next') }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="no-items">
                        <span class="no-items-icon">📦</span>
                        <p class="no-items-title">{{ __('site.shop.items.no_items') }}</p>
                        <p class="no-items-text">{{ __('site.shop.items.check_back') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Display Vouchers -->
            @if($tab === 'vouchers')
            <div class="voucher-container">
                <div class="voucher-box">
                    <h3 class="voucher-title">
                        <span>🎟️</span>{{ __('site.shop.vouchers.redeem_title') }}
                    </h3>
                    
                    @auth
                        <form action="{{ route('app.voucher.postRedem') }}" method="POST">
                            @csrf
                            <div class="voucher-input-wrapper">
                                <input type="text" 
                                       name="code" 
                                       placeholder="{{ __('site.shop.vouchers.code_placeholder') }}" 
                                       class="voucher-input"
                                       required>
                            </div>
                            <button type="submit" class="voucher-submit">
                                {{ __('site.shop.vouchers.redeem_button') }}
                            </button>
                        </form>
                        
                        <p class="voucher-description">
                            {{ __('site.shop.vouchers.description', ['currency' => config('pw-config.currency_name', 'Coins')]) }}
                        </p>
                        
                        @if($voucherLogs->count() > 0)
                        <button onclick="toggleVoucherHistory()" class="voucher-history-button">
                            <span>📋</span> {{ __('site.shop.vouchers.history_button') }}
                        </button>
                        @endif
                    @else
                        <p class="voucher-login-notice">Please <a href="{{ route('login') }}">login</a> to redeem voucher codes</p>
                    @endauth
                </div>
            </div>
            
            <!-- Voucher History Popup -->
            @auth
            @if($voucherLogs->count() > 0)
            <div id="voucherHistoryPopup" class="voucher-history-popup">
                <div class="voucher-history-content">
                    <button onclick="toggleVoucherHistory()" class="voucher-history-close">
                        ×
                    </button>
                    
                    <h2 class="voucher-history-title">
                        <span>📋</span>{{ __('site.shop.vouchers.history_title') }}
                    </h2>
                    
                    <div class="voucher-history-table-wrapper">
                        <table class="voucher-history-table">
                            <thead>
                                <tr>
                                    <th>{{ __('site.shop.vouchers.history_code') }}</th>
                                    <th class="text-center">{{ __('site.shop.vouchers.history_amount') }}</th>
                                    <th class="text-right">{{ __('site.shop.vouchers.history_date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voucherLogs as $log)
                                <tr>
                                    <td>{{ $log->voucher->code ?? 'N/A' }}</td>
                                    <td class="text-center voucher-amount">
                                        +{{ number_format($log->voucher->amount ?? 0) }} {{ config('pw-config.currency_name', 'Coins') }}
                                    </td>
                                    <td class="text-right">
                                        {{ $log->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <p class="voucher-history-summary">
                        {{ __('site.shop.vouchers.total_redeemed', ['count' => $voucherLogs->count()]) }}
                    </p>
                </div>
            </div>
            @endif
            @endauth
            @endif
            
            <!-- Display Services -->
            @if($tab === 'services' && $services->count() > 0)
            <div class="shop-grid">
                @foreach($services as $service)
                    @php
                        $info = $serviceInfo[$service->key] ?? ['name' => ucfirst(str_replace('_', ' ', $service->key)), 'icon' => '⚡', 'description' => ''];
                    @endphp
                    <div class="shop-item">
                        <div class="item-icon service-icon">{{ $info['icon'] }}</div>
                        <h3 class="item-name">{{ __('service.ingame.' . $service->key . '.title') }}</h3>
                        <p class="item-description">{{ __('service.ingame.' . $service->key . '.description') }}</p>
                        
                        <!-- Requirements -->
                        <div class="service-requirements">
                            <strong>{{ __('site.shop.services.requirements') }}</strong>
                            <ul>
                                @foreach(__('service.ingame.' . $service->key . '.requirements') as $requirement)
                                    <li>{{ __('service.' . $requirement) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="item-price">
                            @if($service->currency_type === 'virtual')
                                {{ number_format($service->price) }} {{ config('pw-config.currency_name', 'Coins') }}
                            @else
                                {{ number_format($service->price) }} Gold
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.services.post', $service->key) }}" method="POST" class="service-form">
                                    @csrf
                                    @php
                                        $inputConfig = __('service.ingame.' . $service->key . '.input');
                                    @endphp
                                    
                                    @if(is_array($inputConfig))
                                        <div class="service-input-wrapper">
                                            <input type="{{ $inputConfig['type'] ?? 'text' }}" 
                                                   name="{{ $inputConfig['name'] }}" 
                                                   placeholder="{{ __('service.' . $inputConfig['placeholder']) }}"
                                                   class="service-input"
                                                   required>
                                        </div>
                                    @endif
                                    
                                    <button type="submit" class="purchase-button">
                                        {{ __('site.shop.services.use_button') }}
                                    </button>
                                </form>
                            @else
                                <p class="select-character-notice">{{ __('site.shop.character.select_to_use') }}</p>
                            @endif
                        @else
                            <p class="login-required-notice">{{ __('site.shop.services.login_required') }}</p>
                        @endauth
                    </div>
                @endforeach
            </div>
            @elseif($tab === 'services')
            <div class="no-items">
                <span class="no-items-icon">⚡</span>
                <p class="no-items-title">{{ __('site.shop.services.no_services') }}</p>
                <p class="no-items-message">{{ __('site.shop.services.check_back') }}</p>
            </div>
            @endif
            
            @guest
            <div class="login-notice">
                <p>Please <a href="{{ route('login') }}">login</a> to access the shop</p>
            </div>
            @endguest
</div>
@endsection

@section('styles')
@parent
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

// Auto-hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('[data-notification]');
    notifications.forEach(function(notification) {
        setTimeout(function() {
            notification.style.transition = 'opacity 0.5s ease-out';
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 500);
        }, 5000);
    });
});

// Toggle voucher history popup
function toggleVoucherHistory() {
    const popup = document.getElementById('voucherHistoryPopup');
    if (popup) {
        if (popup.style.display === 'none' || !popup.style.display) {
            popup.style.display = 'block';
            document.body.classList.add('popup-open');
            // Scroll popup to top to ensure content is visible
            popup.scrollTop = 0;
            // Ensure popup is visible in viewport
            const popupContent = popup.querySelector('div');
            if (popupContent) {
                popupContent.scrollIntoView({ behavior: 'instant', block: 'center' });
            }
        } else {
            popup.style.display = 'none';
            document.body.classList.remove('popup-open');
        }
    }
}

// Close popup when clicking outside
document.addEventListener('click', function(event) {
    const popup = document.getElementById('voucherHistoryPopup');
    if (popup && event.target === popup) {
        toggleVoucherHistory();
    }
});
</script>
@endsection