@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.shop'))

@section('body-class', 'shop-page')

@section('content')
<div class="content-section shop-section">
            <h2 class="section-title">Mystical Shop</h2>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div data-notification style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1)); border: 2px solid rgba(16, 185, 129, 0.4); border-radius: 15px; padding: 15px 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 5px 20px rgba(16, 185, 129, 0.3);">
                <p style="color: #10b981; font-size: 1.1rem; margin: 0; font-weight: 600;">
                    <span style="margin-right: 10px;">✓</span>{{ session('success') }}
                </p>
            </div>
            @endif
            
            @if(session('error'))
            <div data-notification style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.4); border-radius: 15px; padding: 15px 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 5px 20px rgba(239, 68, 68, 0.3);">
                <p style="color: #ef4444; font-size: 1.1rem; margin: 0; font-weight: 600;">
                    <span style="margin-right: 10px;">✗</span>{{ session('error') }}
                </p>
            </div>
            @endif
            
            <!-- Search Bar -->
            <div style="text-align: center; margin-bottom: 30px;">
                <form method="GET" action="{{ route('public.shop') }}" style="display: inline-block;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="{{ __('site.shop.search_placeholder') }}" 
                               style="background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.3); border-radius: 10px; padding: 10px 15px; color: #e6d7f0; font-size: 1rem; width: 400px;">
                        <button type="submit" style="background: linear-gradient(45deg, #9370db, #8a2be2); border: none; border-radius: 10px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer;">
                            {{ __('site.shop.search_button') }}
                        </button>
                        @if($search)
                            <a href="{{ route('public.shop') }}" style="color: #b19cd9; text-decoration: none; padding: 10px;">{{ __('site.shop.clear') }}</a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Shop Tabs -->
            <div class="shop-tabs" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;">
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
            
            <!-- Items Layout with Sidebar -->
            @if($tab === 'items')
            <div style="display: flex; gap: 20px; margin-top: 20px;">
                <!-- Category Sidebar -->
                <div style="width: 250px; flex-shrink: 0;">
                    <div style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1)); border: 1px solid rgba(147, 112, 219, 0.3); border-radius: 15px; padding: 20px;">
                        <h3 style="color: #9370db; font-size: 1.2rem; margin-bottom: 15px; text-align: center; font-weight: 600;">{{ __('site.shop.categories.title') }}</h3>
                        <div class="category-sidebar-scroll" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
                            @foreach($categories as $category)
                                <a href="{{ route('public.shop', ['tab' => 'items', 'mask' => $category['mask']]) }}" 
                                   class="category-sidebar-link"
                                   style="display: flex; align-items: center; padding: 12px 15px; margin-bottom: 5px; background: {{ $currentMask == $category['mask'] && ($currentMask !== null || $category['mask'] === null) ? 'linear-gradient(45deg, #9370db, #8a2be2)' : 'rgba(147, 112, 219, 0.1)' }}; border-radius: 10px; text-decoration: none; color: {{ $currentMask == $category['mask'] && ($currentMask !== null || $category['mask'] === null) ? '#fff' : '#b19cd9' }}; transition: all 0.3s ease;">
                                    <span style="font-size: 1.2rem; margin-right: 10px;">{{ $category['icon'] }}</span>
                                    <span style="font-size: 0.95rem; font-weight: 500;">{{ $category['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Items Display Area -->
                <div style="flex-grow: 1;">
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
                                
                                @if($item->poin > 0)
                                <form action="{{ route('app.shop.point.post', $item->id) }}" method="POST" style="margin-top: 10px;">
                                    @csrf
                                    <button type="submit" class="bonus-button">{{ __('site.shop.items.buy_with_bonus', ['points' => $item->poin]) }}</button>
                                </form>
                                @endif
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">{{ __('site.shop.character.select_to_purchase') }}</p>
                            @endif
                        @endauth
                    </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination for items -->
                    @if($items->hasPages())
                    <div style="margin-top: 40px; text-align: center;">
                        <div style="display: inline-flex; gap: 10px; align-items: center;">
                            @if($items->onFirstPage())
                                <span style="padding: 8px 16px; color: #666; cursor: not-allowed;">{{ __('site.shop.pagination.previous') }}</span>
                            @else
                                <a href="{{ $items->previousPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   style="padding: 8px 16px; background: rgba(147, 112, 219, 0.2); color: #dda0dd; text-decoration: none; border-radius: 8px; transition: all 0.3s;">
                                    {{ __('site.shop.pagination.previous') }}
                                </a>
                            @endif
                            
                            <span style="color: #b19cd9; padding: 0 10px;">
                                {{ __('site.shop.pagination.page_of', ['current' => $items->currentPage(), 'total' => $items->lastPage()]) }}
                            </span>
                            
                            @if($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   style="padding: 8px 16px; background: rgba(147, 112, 219, 0.2); color: #dda0dd; text-decoration: none; border-radius: 8px; transition: all 0.3s;">
                                    {{ __('site.shop.pagination.next') }}
                                </a>
                            @else
                                <span style="padding: 8px 16px; color: #666; cursor: not-allowed;">{{ __('site.shop.pagination.next') }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div style="text-align: center; padding: 60px 20px;">
                        <span style="font-size: 4rem; display: block; margin-bottom: 20px;">📦</span>
                        <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">{{ __('site.shop.items.no_items') }}</p>
                        <p style="color: #b19cd9;">{{ __('site.shop.items.check_back') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Display Vouchers -->
            @if($tab === 'vouchers')
            <div style="text-align: center; padding: 40px 20px;">
                <div style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1)); border: 2px solid rgba(147, 112, 219, 0.3); border-radius: 20px; padding: 30px; display: inline-block; max-width: 500px;">
                    <h3 style="color: #9370db; font-size: 1.5rem; margin-bottom: 20px; text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);">
                        <span style="margin-right: 10px;">🎟️</span>{{ __('site.shop.vouchers.redeem_title') }}
                    </h3>
                    
                    @auth
                        <form action="{{ route('app.voucher.postRedem') }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 20px;">
                                <input type="text" 
                                       name="code" 
                                       placeholder="{{ __('site.shop.vouchers.code_placeholder') }}" 
                                       style="background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.5); border-radius: 10px; padding: 12px 20px; color: #e6d7f0; font-size: 1rem; width: 100%; font-family: Arial, sans-serif;"
                                       required>
                            </div>
                            <button type="submit" style="background: linear-gradient(45deg, #9370db, #8a2be2); border: none; border-radius: 20px; padding: 12px 40px; color: white; font-weight: 600; cursor: pointer; font-size: 1.1rem; transition: all 0.3s ease;">
                                {{ __('site.shop.vouchers.redeem_button') }}
                            </button>
                        </form>
                        
                        <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 20px;">
                            {{ __('site.shop.vouchers.description', ['currency' => config('pw-config.currency_name', 'Coins')]) }}
                        </p>
                        
                        @if($voucherLogs->count() > 0)
                        <button onclick="toggleVoucherHistory()" style="background: rgba(147, 112, 219, 0.2); border: 1px solid rgba(147, 112, 219, 0.4); border-radius: 15px; padding: 8px 20px; color: #b19cd9; font-weight: 500; cursor: pointer; font-size: 0.9rem; margin-top: 15px; transition: all 0.3s ease;">
                            <span style="margin-right: 5px;">📋</span> {{ __('site.shop.vouchers.history_button') }}
                        </button>
                        @endif
                    @else
                        <p style="color: #b19cd9; font-size: 1rem;">Please <a href="{{ route('login') }}" style="color: #9370db; text-decoration: underline;">login</a> to redeem voucher codes</p>
                    @endauth
                </div>
            </div>
            
            <!-- Voucher History Popup -->
            @auth
            @if($voucherLogs->count() > 0)
            <div id="voucherHistoryPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); z-index: 10000; overflow-y: auto; padding: 20px; color: #e6d7f0;">
                <div style="position: relative; max-width: 800px; margin: 50px auto 50px auto; background: linear-gradient(135deg, #1a0f2e, #2a1b3d); border: 2px solid rgba(147, 112, 219, 0.4); border-radius: 20px; padding: 30px; box-shadow: 0 20px 60px rgba(147, 112, 219, 0.6); color: #e6d7f0;">
                    <button onclick="toggleVoucherHistory()" style="position: absolute; top: 15px; right: 15px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 50%; width: 40px; height: 40px; color: #ef4444; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease; z-index: 1; line-height: 1;">
                        ×
                    </button>
                    
                    <h2 style="color: #9370db; font-size: 1.8rem; margin-bottom: 25px; text-align: center; text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);">
                        <span style="margin-right: 10px;">📋</span>{{ __('site.shop.vouchers.history_title') }}
                    </h2>
                    
                    <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; background: linear-gradient(135deg, #1a0f2e, #2a1b3d); z-index: 1;">
                                <tr style="border-bottom: 2px solid rgba(147, 112, 219, 0.4);">
                                    <th style="padding: 12px; text-align: left; color: #9370db; font-weight: 600;">{{ __('site.shop.vouchers.history_code') }}</th>
                                    <th style="padding: 12px; text-align: center; color: #9370db; font-weight: 600;">{{ __('site.shop.vouchers.history_amount') }}</th>
                                    <th style="padding: 12px; text-align: right; color: #9370db; font-weight: 600;">{{ __('site.shop.vouchers.history_date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voucherLogs as $log)
                                <tr style="border-bottom: 1px solid rgba(147, 112, 219, 0.2);">
                                    <td style="padding: 12px; color: #e6d7f0;">{{ $log->voucher->code ?? 'N/A' }}</td>
                                    <td style="padding: 12px; text-align: center; color: #10b981; font-weight: 600;">
                                        +{{ number_format($log->voucher->amount ?? 0) }} {{ config('pw-config.currency_name', 'Coins') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #b19cd9;">
                                        {{ $log->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <p style="text-align: center; color: #b19cd9; font-size: 0.9rem; margin-top: 20px;">
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
                        <div class="item-icon" style="font-size: 3rem;">{{ $info['icon'] }}</div>
                        <h3 class="item-name">{{ __('service.ingame.' . $service->key . '.title') }}</h3>
                        <p class="item-description">{{ __('service.ingame.' . $service->key . '.description') }}</p>
                        
                        <!-- Requirements -->
                        <div style="margin-top: 10px; margin-bottom: 15px; font-size: 0.85rem; color: #b19cd9;">
                            <strong>{{ __('site.shop.services.requirements') }}</strong>
                            <ul style="list-style: disc; margin-left: 20px; margin-top: 5px;">
                                @foreach(__('service.ingame.' . $service->key . '.requirements') as $requirement)
                                    <li style="color: #9370db;">{{ __('service.' . $requirement) }}</li>
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
                                <form action="{{ route('app.services.post', $service->key) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    @php
                                        $inputConfig = __('service.ingame.' . $service->key . '.input');
                                    @endphp
                                    
                                    @if(is_array($inputConfig))
                                        <div style="margin-bottom: 15px;">
                                            <input type="{{ $inputConfig['type'] ?? 'text' }}" 
                                                   name="{{ $inputConfig['name'] }}" 
                                                   placeholder="{{ __('service.' . $inputConfig['placeholder']) }}"
                                                   style="width: 100%; background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.5); border-radius: 8px; padding: 10px; color: #e6d7f0; font-size: 0.95rem; font-family: Arial, sans-serif;"
                                                   required>
                                        </div>
                                    @endif
                                    
                                    <button type="submit" class="purchase-button">
                                        {{ __('site.shop.services.use_button') }}
                                    </button>
                                </form>
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">{{ __('site.shop.character.select_to_use') }}</p>
                            @endif
                        @else
                            <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">{{ __('site.shop.services.login_required') }}</p>
                        @endauth
                    </div>
                @endforeach
            </div>
            @elseif($tab === 'services')
            <div style="text-align: center; padding: 60px 20px;">
                <span style="font-size: 4rem; display: block; margin-bottom: 20px;">⚡</span>
                <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">{{ __('site.shop.services.no_services') }}</p>
                <p style="color: #b19cd9;">{{ __('site.shop.services.check_back') }}</p>
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