@extends('layouts.auth')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - Enter the Realm')

@section('body-class', 'pre-login-page')

@section('content')
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="auth-container">
        <div class="mystical-border"></div>
        
        <div class="auth-header">
            <p class="auth-tagline">{{ __('auth.welcome_realm') }}</p>
        </div>

        <form class="auth-form" method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <label for="username">{{ __('auth.username') }}</label>
                <input type="text" id="username" name="name" placeholder="{{ __('auth.enter_username') }}" 
                       value="{{ old('name') }}" required autofocus autocomplete="username">
                <div class="input-icon">👤</div>
            </div>
            
            <div class="form-group">
                <label for="password">{{ __('auth.password') }}</label>
                <input type="password" id="password" name="password" placeholder="{{ __('auth.enter_password') }}" 
                       required autocomplete="current-password">
                <div class="input-icon">🗝️</div>
            </div>
            
            <div class="form-group" id="pin-group">
                <label for="pin">{{ __('auth.pin') }}</label>
                <input type="password" id="pin" name="pin" placeholder="{{ __('auth.enter_pin') }}" 
                       pattern="[0-9]{4,6}" maxlength="6" autocomplete="current-pin">
                <div class="input-icon">🔐</div>
            </div>
            
            @if( config('pw-config.system.apps.captcha') )
                <div class="form-group">
                    <label for="captcha">{{ __('auth.verification') }}</label>
                    <div class="captcha-wrapper">
                        @captcha
                    </div>
                    <input type="text" id="captcha" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    <div class="input-icon">🛡️</div>
                </div>
            @endif
            
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('auth.remember_path') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">{{ __('auth.reset_password') }}</a>
                @endif
            </div>
            
            <button type="submit" class="auth-button">
                <span class="button-text">{{ __('auth.enter_haven') }}</span>
                <div class="loading-spinner"></div>
            </button>
            
            @if (Route::has('register'))
                <div class="auth-link">
                    <p>{{ __('auth.new_to_haven') }} <a href="{{ route('register') }}">{{ __('auth.register_here') }}</a></p>
                </div>
            @endif
        </form>
    </div>
@endsection

@section('scripts')
<script>
    // Create floating mystical particles
    function createParticles() {
        const particlesContainer = document.querySelector('.floating-particles');
        const numberOfParticles = 80;

        for (let i = 0; i < numberOfParticles; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = 100 + '%';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.animationDuration = (Math.random() * 8 + 8) + 's';
            
            // Random purple particle colors
            const colors = ['#9370db', '#8a2be2', '#4b0082', '#dda0dd'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
            particle.style.boxShadow = `0 0 10px ${color}`;
            
            particlesContainer.appendChild(particle);
        }
    }

    // Check if user needs PIN
    async function checkPinRequired(username) {
        const pinGroup = document.getElementById('pin-group');
        const pinInput = document.getElementById('pin');
        
        if (!username) {
            pinGroup.classList.remove('show');
            pinInput.required = false;
            pinInput.value = '';
            return;
        }

        try {
            const response = await fetch('{{ route("api.check-pin") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username: username })
            });

            const data = await response.json();
            console.log('PIN check response:', data); // Debug log
            
            if (data.pin_required) {
                pinGroup.classList.add('show');
                pinInput.required = true;
                // Focus on PIN field after it appears
                setTimeout(() => pinInput.focus(), 100);
            } else {
                pinGroup.classList.remove('show');
                pinInput.required = false;
                pinInput.value = '';
            }
        } catch (error) {
            console.error('Error checking PIN requirement:', error);
            // Hide PIN field on error
            pinGroup.classList.remove('show');
            pinInput.required = false;
        }
    }

    // Enhanced login form interactions
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const button = document.querySelector('.auth-button');
        const buttonText = button.querySelector('.button-text');
        const spinner = button.querySelector('.loading-spinner');
        
        // Show loading state
        buttonText.style.display = 'none';
        spinner.style.display = 'block';
        button.disabled = true;
        button.style.background = 'linear-gradient(45deg, #32cd32, #00ff7f)';
        button.style.transform = 'scale(0.95)';
        
        // Create mystical portal effect
        const rect = button.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        for (let i = 0; i < 5; i++) {
            setTimeout(() => {
                const portal = document.createElement('div');
                portal.style.cssText = `
                    position: fixed;
                    left: ${centerX}px;
                    top: ${centerY}px;
                    width: 10px;
                    height: 10px;
                    background: radial-gradient(circle, rgba(147,112,219,0.8), transparent);
                    border-radius: 50%;
                    pointer-events: none;
                    animation: portalExpand 1.5s ease-out forwards;
                    z-index: 9999;
                `;
                document.body.appendChild(portal);
                setTimeout(() => portal.remove(), 1500);
            }, i * 200);
        }
        
        // Form will submit naturally without preventDefault
    });

    // Check PIN on username blur
    document.getElementById('username').addEventListener('blur', function() {
        checkPinRequired(this.value);
    });

    // Check PIN on username input (debounced)
    let pinCheckTimeout;
    document.getElementById('username').addEventListener('input', function() {
        clearTimeout(pinCheckTimeout);
        pinCheckTimeout = setTimeout(() => {
            checkPinRequired(this.value);
        }, 500);
    });

    // Input field magic effects
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.filter = 'brightness(1.2)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            this.parentElement.style.filter = 'brightness(1)';
        });
    });

    // Mystical hover effects
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Initialize particles
    createParticles();

    // Add portal expansion animation
    const portalStyle = document.createElement('style');
    portalStyle.textContent = `
        @keyframes portalExpand {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(30);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(portalStyle);

    // Add entrance animation
    window.addEventListener('load', function() {
        document.querySelector('.auth-container').style.animation = 'fadeInScale 1.5s ease-out';
        const entranceStyle = document.createElement('style');
        entranceStyle.textContent = `
            @keyframes fadeInScale {
                0% {
                    opacity: 0;
                    transform: scale(0.8) translateY(50px);
                }
                100% {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }
        `;
        document.head.appendChild(entranceStyle);
    });
</script>
@endsection