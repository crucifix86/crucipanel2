@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.nav.donate'))

@section('body-class', 'donate-page')

@section('content')

<div class="content-section donate-section">
            <h2 class="section-title">{{ __('site.donate.title') }}</h2>
            <p class="section-subtitle">{{ __('site.donate.subtitle') }}</p>
            
            <div class="donation-methods">
                @if($paypalConfig['enabled'])
                <div class="donation-method">
                    <span class="method-icon">💳</span>
                    <h3 class="method-name">{{ __('site.donate.methods.paypal.name') }}</h3>
                    <p class="method-description">{{ __('site.donate.methods.paypal.description', ['currency' => $currency]) }}</p>
                    <div class="payment-details">
                        <div class="detail-item">
                            <span class="detail-label">{{ __('site.donate.details.rate') }}</span>
                            <span class="detail-value">{{ $paypalConfig['currency'] }} {{ number_format($paypalConfig['rate'], 2) }} = 1 {{ $currency }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">{{ __('site.donate.details.minimum') }}</span>
                            <span class="detail-value">{{ $paypalConfig['currency'] }} {{ number_format($paypalConfig['minimum'], 2) }}</span>
                        </div>
                        @if($paypalConfig['double'])
                        <div class="detail-item bonus">
                            <span class="detail-label">{{ __('site.donate.details.bonus') }}</span>
                            <span class="detail-value">{{ __('site.donate.details.double_active', ['currency' => $currency]) }}</span>
                        </div>
                        @endif
                    </div>
                    @auth
                        <a href="{{ route('app.donate.paypal') }}" class="donate-button">{{ __('site.donate.methods.paypal.button') }}</a>
                    @else
                        <span class="method-status">{{ __('site.donate.methods.login_required') }}</span>
                    @endauth
                </div>
                @endif
                
                @if($bankConfig['enabled'])
                <div class="donation-method">
                    <span class="method-icon">🏦</span>
                    <h3 class="method-name">{{ __('site.donate.methods.bank.name') }}</h3>
                    <p class="method-description">{{ __('site.donate.methods.bank.description') }}</p>
                    <div class="payment-details">
                        <div class="detail-item">
                            <span class="detail-label">{{ __('site.donate.details.rate') }}</span>
                            <span class="detail-value">{{ $bankConfig['currency'] ?? 'IDR' }} {{ number_format($bankConfig['rate'], 0) }} = 1 {{ $currency }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">{{ __('site.donate.details.minimum') }}</span>
                            <span class="detail-value">{{ $bankConfig['minimum'] }} {{ $currency }}</span>
                        </div>
                        @if($bankConfig['double'])
                        <div class="detail-item bonus">
                            <span class="detail-label">{{ __('site.donate.details.bonus') }}</span>
                            <span class="detail-value">{{ __('site.donate.details.double_active', ['currency' => $currency]) }}</span>
                        </div>
                        @endif
                        @if(count($bankConfig['banks']) > 0)
                        <div class="bank-accounts">
                            <p class="bank-title">{{ __('site.donate.methods.bank.available_banks') }}</p>
                            @foreach($bankConfig['banks'] as $bank)
                                <div class="bank-info">{{ $bank['name'] }}</div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @auth
                        <a href="{{ route('app.donate.bank') }}" class="donate-button">{{ __('site.donate.methods.bank.button') }}</a>
                    @else
                        <span class="method-status">{{ __('site.donate.methods.login_required') }}</span>
                    @endauth
                </div>
                @endif
                
                @if($paymentwallEnabled)
                <div class="donation-method">
                    <span class="method-icon">🌐</span>
                    <h3 class="method-name">{{ __('site.donate.methods.paymentwall.name') }}</h3>
                    <p class="method-description">{{ __('site.donate.methods.paymentwall.description') }}</p>
                    @auth
                        <a href="{{ route('app.donate.paymentwall') }}" class="donate-button">{{ __('site.donate.methods.paymentwall.button') }}</a>
                    @else
                        <span class="method-status">{{ __('site.donate.methods.login_required') }}</span>
                    @endauth
                </div>
                @endif
                
                @if($ipaymuEnabled)
                <div class="donation-method">
                    <span class="method-icon">📱</span>
                    <h3 class="method-name">{{ __('site.donate.methods.ipaymu.name') }}</h3>
                    <p class="method-description">{{ __('site.donate.methods.ipaymu.description') }}</p>
                    @auth
                        <a href="{{ route('app.donate.ipaymu') }}" class="donate-button">{{ __('site.donate.methods.ipaymu.button') }}</a>
                    @else
                        <span class="method-status">{{ __('site.donate.methods.login_required') }}</span>
                    @endauth
                </div>
                @endif
                
                @if(!$paypalConfig['enabled'] && !$bankConfig['enabled'] && !$paymentwallEnabled && !$ipaymuEnabled)
                <div style="text-align: center; padding: 60px 20px;">
                    <span style="font-size: 4rem; display: block; margin-bottom: 20px;">💳</span>
                    <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">{{ __('site.donate.methods.no_methods') }}</p>
                    <p style="color: #b19cd9;">{{ __('site.donate.methods.contact_admin') }}</p>
                </div>
                @endif
            </div>
            
            <div class="benefits-section">
                <h3 class="benefits-title">{{ __('site.donate.benefits.title') }}</h3>
                <div class="benefits-list">
                    <div class="benefit-item">
                        <span class="benefit-icon">💎</span>
                        <p class="benefit-text">{{ __('site.donate.benefits.points', ['currency' => $currency]) }}</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">🎁</span>
                        <p class="benefit-text">{{ __('site.donate.benefits.rewards') }}</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">⚡</span>
                        <p class="benefit-text">{{ __('site.donate.benefits.instant') }}</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">🛡️</span>
                        <p class="benefit-text">{{ __('site.donate.benefits.secure') }}</p>
                    </div>
                </div>
            </div>
            
            @guest
            <div class="login-notice">
                <p>{{ __('site.donate.login_notice') }}</p>
            </div>
            @else
            <div class="login-notice" style="color: #9370db;">
                <p>{{ __('site.donate.welcome_donor', ['name' => Auth::user()->truename ?? Auth::user()->name]) }}</p>
            </div>
            @endguest
</div>
@endsection

@section('styles')
@parent
@endsection