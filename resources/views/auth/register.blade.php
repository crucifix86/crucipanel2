@extends('layouts.auth')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - Create Your Legend')

@section('body-class', 'register-page')

@section('content')
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="auth-container register-container">
        <div class="mystical-border"></div>
        
        <div class="auth-header">
            <p class="auth-tagline">{{ __('auth.create_legend') }}</p>
        </div>

        <form class="auth-form" method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="username">{{ __('auth.form.login_placeholder') }}</label>
                <input type="text" id="username" name="name" placeholder="Enter your username" 
                       value="{{ old('name') }}" required autofocus autocomplete="username">
                <div class="input-icon">👤</div>
            </div>
            
            <div class="form-group">
                <label for="email">{{ __('auth.form.email') }}</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" 
                       value="{{ old('email') }}" required autocomplete="email">
                <div class="input-icon">✉️</div>
            </div>
            
            <div class="form-group">
                <label for="password">{{ __('auth.form.password') }}</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" 
                       required autocomplete="new-password">
                <div class="input-icon">🗝️</div>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">{{ __('auth.form.confirmPassword') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       placeholder="Confirm your password" required autocomplete="new-password">
                <div class="input-icon">🔐</div>
            </div>
            
            @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                <div class="form-group">
                    <label for="pin">{{ __('auth.form.pin') }}</label>
                    <input type="password" id="pin" name="pin" placeholder="Enter your 4-6 digit PIN" 
                           pattern="[0-9]{4,6}" maxlength="6" required autocomplete="new-pin">
                    <div class="input-icon">🔒</div>
                </div>
            @endif
            
            @if( config('pw-config.system.apps.captcha') )
                <div class="form-group">
                    <label for="captcha">Verification Code</label>
                    <div class="captcha-wrapper">
                        <span id="captcha-container">{!! captcha_img() !!}</span>
                        <a href="javascript:void(0)" onclick="refreshCaptcha()" style="margin-left: 10px; color: #9370db;">🔄</a>
                    </div>
                    <input type="text" id="captcha" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    <div class="input-icon">🛡️</div>
                </div>
            @endif
            
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="form-check">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                        ]) !!}
                    </label>
                </div>
            @endif
            
            <button type="submit" class="auth-button">
                <span class="button-text">Begin Your Journey</span>
                <div class="loading-spinner"></div>
            </button>
            
            <div class="auth-link">
                <p>{{ __('auth.already_account') }} <a href="{{ route('login') }}">{{ __('auth.login_here') }}</a></p>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    // Create floating mystical particles
    function createParticles() {
        const particlesContainer = document.querySelector('.floating-particles');
        const numberOfParticles = 60;

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

    // Enhanced register form interactions
    document.getElementById('registerForm').addEventListener('submit', function(e) {
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

    // Refresh captcha function
    function refreshCaptcha() {
        const container = document.getElementById('captcha-container');
        const timestamp = new Date().getTime();
        container.innerHTML = '<img src="/captcha/default?' + timestamp + '" alt="captcha">';
    }

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