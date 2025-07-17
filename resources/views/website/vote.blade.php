@php
if (!function_exists('get_setting')) {
    require_once app_path('Helpers/settings.php');
}
@endphp

@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.vote.title'))

@section('body-class', 'vote-page')


@section('content')
<div class="vote-content">
    <div class="vote-header">
        <h1 class="vote-title">{{ __('site.vote.main_title') }}</h1>
        <p class="vote-subtitle">{{ __('site.vote.subtitle') }}</p>
    </div>
            
    @if( config('arena.test_mode') || config('arena.test_mode_clear_timer') )
    <div class="test-mode-warning">
        <h3>⚠️ {{ __('site.vote.test_mode_active') }}</h3>
        <p>
            @if( config('arena.test_mode') )
                • {{ __('site.vote.test_mode_info.callbacks') }}<br>
            @endif
            @if( config('arena.test_mode_clear_timer') )
                • {{ __('site.vote.test_mode_info.cooldown') }}<br>
            @endif
            <strong>{{ __('site.vote.test_mode_info.reminder') }}</strong>
        </p>
    </div>
    @endif
            
    @auth
    <!-- User Info Bar -->
    <div class="user-info-bar">
        <div class="user-balance">
            <div class="balance-item">
                <span class="balance-icon">💰</span>
                <span class="balance-label">{{ config('pw-config.currency_name', 'Coins') }}:</span>
                <span class="balance-value">{{ number_format(Auth::user()->money, 0, '', '.') }}</span>
            </div>
            <div class="balance-item">
                <span class="balance-icon">⭐</span>
                <span class="balance-label">{{ __('site.shop.balance.bonus_points') }}</span>
                <span class="balance-value">{{ number_format(Auth::user()->bonuses, 0, '', '.') }}</span>
            </div>
        </div>
    </div>
    @endauth
            
    <!-- Session Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        ✓ {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">
        ✗ {{ session('error') }}
    </div>
    @endif
            
            <!-- Arena Vote Success Notification -->
            @if(isset($arena_vote_success) && $arena_vote_success)
            @php
                $arenaSuccess = $arena_vote_success;
            @endphp
            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(147, 112, 219, 0.2)); border: 2px solid #10b981; padding: 20px 30px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                <span style="font-size: 2rem; display: block; margin-bottom: 10px;">🎉</span>
                <span style="color: #10b981; font-size: 1.3rem; font-weight: 600; display: block; margin-bottom: 10px;">
                    {{ __('site.vote.arena.vote_confirmed') }}
                </span>
                <span style="color: #e6d7f0; font-size: 1.1rem;">
                    +{{ $arenaSuccess['reward_amount'] }} 
                    @if($arenaSuccess['reward_type'] == 'virtual')
                        {{ config('pw-config.currency_name', 'Coins') }}
                    @elseif($arenaSuccess['reward_type'] == 'cubi')
                        {{ __('site.vote.arena.gold') }}
                    @else
                        {{ __('site.shop.balance.bonus_points') }}
                    @endif
                    {{ __('site.vote.arena.reward_added', ['amount' => $arenaSuccess['reward_amount'], 'type' => $rewardText]) }}
                </span>
                @php
                    $rewardText = '';
                    if($arenaSuccess['reward_type'] == 'virtual') {
                        $rewardText = config('pw-config.currency_name', 'Coins');
                    } elseif($arenaSuccess['reward_type'] == 'cubi') {
                        $rewardText = __('site.vote.arena.gold');
                    } else {
                        $rewardText = __('site.shop.balance.bonus_points');
                    }
                @endphp
                <script>
                    // Show immediate notification as well
                    showNotification('success', '{{ __('site.vote.arena.confirmed_message', ['amount' => $arenaSuccess['reward_amount'], 'type' => $rewardText]) }}');
                </script>
            </div>
            @endif
            
    <!-- Arena Top 100 Section -->
    @if(get_setting('arena.status', config('arena.status', true)) === true && Auth::check())
    <div class="arena-section">
        <div class="arena-header">
            <h3 class="arena-title">
                🏆 {{ __('site.vote.arena.title') }}
            </h3>
                        <div class="arena-reward">
                            <span class="reward-amount">+{{ get_setting('arena.reward', config('arena.reward', 10)) }}</span>
                            <span class="reward-type">
                                @if(get_setting('arena.reward_type', config('arena.reward_type', 'virtual')) === 'cubi')
                                    {{ __('site.vote.arena.gold') }}
                                @elseif(get_setting('arena.reward_type', config('arena.reward_type', 'virtual')) === 'virtual')
                                    {{ config('pw-config.currency_name', 'Coins') }}
                                @else
                                    {{ __('site.shop.balance.bonus_points') }}
                                @endif
                            </span>
                        </div>
                    </div>
        <p class="arena-description">{{ __('site.vote.arena.description', ['hours' => get_setting('arena.time', config('arena.time', 1))]) }}</p>
        <div style="text-align: center;">
            @if(isset($arena_info[Auth::user()->ID]) && $arena_info[Auth::user()->ID]['status'])
                <form id="vote-form-arena" action="{{ route('public.vote.arena.redirect') }}" method="GET" target="_blank" onsubmit="return handleVoteSubmit('Arena Top 100', 'arena', {{ get_setting('arena.reward', config('arena.reward', 10)) }}, '{{ get_setting('arena.reward_type', config('arena.reward_type', 'virtual')) }}');">
                    @csrf
                    <button type="submit" class="vote-button arena-button">
                        🗳️ {{ __('site.vote.arena.button') }}
                    </button>
                </form>
            @else
                <div class="cooldown-timer" data-time="{{ $arena_info[Auth::user()->ID]['end_time'] ?? 0 }}">
                    <span class="cooldown-icon">⏱️</span>
                    <span class="cooldown-text">{{ __('site.vote.cooldown.please_wait') }} <span class="time-remaining">--:--:--</span></span>
                </div>
            @endif
        </div>
    </div>
    @endif
            
    <div class="vote-info-section">
        <h3 class="info-title">{{ __('site.vote.why_vote.title') }}</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-icon">💰</span>
                <p class="info-text">{{ __('site.vote.why_vote.earn_currency') }}</p>
            </div>
            <div class="info-item">
                <span class="info-icon">📈</span>
                <p class="info-text">{{ __('site.vote.why_vote.help_grow') }}</p>
            </div>
            <div class="info-item">
                <span class="info-icon">🎯</span>
                <p class="info-text">{{ __('site.vote.why_vote.daily_rewards') }}</p>
            </div>
            <div class="info-item">
                <span class="info-icon">🏆</span>
                <p class="info-text">{{ __('site.vote.why_vote.top_prizes') }}</p>
            </div>
        </div>
    </div>
            
    @guest
    <div class="login-notice">
        <p>{{ __('site.vote.login_notice') }}</p>
    </div>
    @endguest
</div>

@endsection

@section('scripts')
@parent

    <script>
        // Countdown timer functionality
        function updateTimers() {
            const timers = document.querySelectorAll('.cooldown-timer');
            timers.forEach(timer => {
                const timeLeft = parseInt(timer.getAttribute('data-time'));
                const display = timer.querySelector('.time-remaining');
                
                if (timeLeft > 0) {
                    const hours = Math.floor(timeLeft / 3600);
                    const minutes = Math.floor((timeLeft % 3600) / 60);
                    const seconds = timeLeft % 60;
                    
                    display.textContent = 
                        String(hours).padStart(2, '0') + ':' +
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');
                    
                    timer.setAttribute('data-time', timeLeft - 1);
                } else {
                    // Reload page when timer expires
                    location.reload();
                }
            });
        }

        // Update timers every second
        setInterval(updateTimers, 1000);
        updateTimers(); // Initial update

        // Create floating mystical particles
        function createParticles() {
            const particlesContainer = document.querySelector('.floating-particles');
            const numberOfParticles = 60;

            for (let i = 0; i < numberOfParticles; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 6 + 6) + 's';
                
                // Random purple colors for particles
                const colors = ['#9370db', '#8a2be2', '#4b0082', '#6a5acd'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });

        // Simple PIN check
        const usernameInput = document.querySelector('input[name="name"]');
        const pinField = document.getElementById('pin-field');
        
        if (usernameInput) {
            usernameInput.addEventListener('blur', function() {
                if (this.value.length > 2) {
                    // For simplicity, show PIN field for all users
                    // In production, you'd check via API
                    pinField.style.display = 'block';
                }
            });
        }

        // Login box collapse functionality
        function toggleLoginBox() {
            const loginBox = document.getElementById('loginBox');
            loginBox.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = loginBox.classList.contains('collapsed');
            localStorage.setItem('loginBoxCollapsed', isCollapsed);
        }

        // Restore login box state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const loginBox = document.getElementById('loginBox');
            const savedState = localStorage.getItem('loginBoxCollapsed');
            
            // If user has never interacted with it, keep it collapsed (default)
            // If user has explicitly expanded it, respect their choice
            if (savedState === 'false') {
                loginBox.classList.remove('collapsed');
            }
            // Otherwise it stays collapsed (default state or explicitly collapsed)
        });

        // Add page entrance animation
        window.addEventListener('load', function() {
            document.querySelector('.container').style.animation = 'fadeInUp 1.5s ease-out';
            const fadeInUpStyle = document.createElement('style');
            fadeInUpStyle.textContent = `
                @keyframes fadeInUp {
                    0% {
                        opacity: 0;
                        transform: translateY(50px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(fadeInUpStyle);
        });
        
        // Vote functions
        function handleVoteSubmit(siteName, siteId, rewardAmount, rewardType) {
            // For Arena Top 100
            if (siteId === 'arena') {
                showNotification('info', '{{ __('site.vote.arena.opening_message') }}');
                
                // Start checking for vote completion
                startVoteStatusCheck();
                
                return true;
            }
            
            // This shouldn't happen anymore but just in case
            showNotification('error', '{{ __('site.vote.arena.only_supported') }}');
            return false;
        }
        
        // Check vote status periodically
        let voteCheckInterval = null;
        function startVoteStatusCheck() {
            // Clear any existing interval
            if (voteCheckInterval) {
                clearInterval(voteCheckInterval);
            }
            
            // Check every 3 seconds
            voteCheckInterval = setInterval(() => {
                fetch('/api/check-arena-vote-status')
                    .then(response => response.json())
                    .then(data => {
                        if (data.completed) {
                            // Vote completed!
                            clearInterval(voteCheckInterval);
                            voteCheckInterval = null;
                            
                            // Show success notification
                            let message = '{{ __('site.vote.js.vote_confirmed') }}';
                            message = message.replace(':amount', data.reward_amount).replace(':type', data.reward_type);
                            showNotification('success', message);
                            
                            // Update balance display
                            if (data.new_balance) {
                                updateBalanceDisplay(data.new_balance);
                            }
                            
                            // Reload page after 2 seconds to update timers
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('{{ __('site.vote.js.error_checking') }}', error);
                    });
            }, 3000);
            
            // Stop checking after 2 minutes
            setTimeout(() => {
                if (voteCheckInterval) {
                    clearInterval(voteCheckInterval);
                    voteCheckInterval = null;
                }
            }, 120000);
        }
        
        function updateBalanceDisplay(newBalance) {
            // Update money display
            const moneyElements = document.querySelectorAll('.balance-value');
            if (moneyElements[0]) {
                moneyElements[0].textContent = new Intl.NumberFormat('en-US').format(newBalance.money);
                // Add flash effect
                moneyElements[0].style.animation = 'balanceFlash 1s ease-in-out';
            }
            
            // Update bonuses display
            if (moneyElements[1]) {
                moneyElements[1].textContent = new Intl.NumberFormat('en-US').format(newBalance.bonuses);
                // Add flash effect
                moneyElements[1].style.animation = 'balanceFlash 1s ease-in-out';
            }
        }
        
        function showNotification(type, message) {
            // Remove any existing notifications
            const existingNotif = document.querySelector('.vote-notification');
            if (existingNotif) {
                existingNotif.remove();
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'vote-notification';
            
            let bgColor, borderColor, textColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'rgba(16, 185, 129, 0.2)';
                    borderColor = '#10b981';
                    textColor = '#10b981';
                    icon = '✓';
                    break;
                case 'info':
                    bgColor = 'rgba(59, 130, 246, 0.2)';
                    borderColor = '#3b82f6';
                    textColor = '#3b82f6';
                    icon = 'ℹ️';
                    break;
                default:
                    bgColor = 'rgba(239, 68, 68, 0.2)';
                    borderColor = '#ef4444';
                    textColor = '#ef4444';
                    icon = '✗';
            }
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                border: 2px solid ${borderColor};
                padding: 20px 30px;
                border-radius: 15px;
                z-index: 10000;
                max-width: 400px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                animation: slideIn 0.3s ease-out;
            `;
            
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-size: 1.5rem;">${icon}</span>
                    <span style="color: ${textColor}; font-size: 1.1rem; font-weight: 600;">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove after 10 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 10000);
        }
        
        // Add animations
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            @keyframes balanceFlash {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); color: #ffd700; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8); }
            }
        `;
        document.head.appendChild(notificationStyle);
        
        // Check if vote was submitted when page regains focus
        window.addEventListener('focus', function() {
            if (sessionStorage.getItem('vote_submitted')) {
                sessionStorage.removeItem('vote_submitted');
                // Refresh page to show updated balance and cooldowns
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    </script>
@endsection