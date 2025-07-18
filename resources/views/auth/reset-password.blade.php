@extends('layouts.auth')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('auth.form.resetPassword'))

@section('body-class', 'reset-password-page')

@section('content')
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="phoenix-ornament phoenix-left">🔥</div>
    <div class="phoenix-ornament phoenix-right">🔥</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="auth-container">
        <div class="mystical-border"></div>
        
        <div class="auth-header">
            <p class="auth-tagline">{{ __('auth.form.resetPassword') }}</p>
        </div>

        <form class="auth-form" method="POST" action="{{ route('password.update') }}" id="resetForm">
            @csrf
            
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            
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
                <label for="email">{{ __('auth.form.email') }}</label>
                <input type="email" id="email" name="email" placeholder="{{ __('auth.enter_email') }}" 
                       value="{{ old('email', $request->email) }}" required autofocus autocomplete="email">
                <div class="input-icon">✉️</div>
            </div>
            
            <div class="form-group">
                <label for="password">{{ __('auth.form.password') }}</label>
                <input type="password" id="password" name="password" placeholder="{{ __('auth.enter_new_password') }}" 
                       required autocomplete="new-password">
                <div class="input-icon">🗝️</div>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">{{ __('auth.form.confirmPassword') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       placeholder="{{ __('auth.confirm_new_password') }}" required autocomplete="new-password">
                <div class="input-icon">🔐</div>
            </div>
            
            @if( config('pw-config.pin_required') )
                <div class="form-section">
                    <h3 class="section-title">{{ __('auth.form.pin') }}</h3>
                    
                    <div class="form-group">
                        <label for="pin">{{ __('auth.form.pin') }}</label>
                        <input type="password" id="pin" name="pin" placeholder="{{ __('auth.enter_new_pin') }}" 
                               pattern="[0-9]{4,6}" maxlength="6" required autocomplete="new-pin">
                        <div class="input-icon">🔢</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pin_confirmation">{{ __('auth.form.confirmPin') }}</label>
                        <input type="password" id="pin_confirmation" name="pin_confirmation" 
                               placeholder="{{ __('auth.confirm_new_pin') }}" pattern="[0-9]{4,6}" maxlength="6" required>
                        <div class="input-icon">🔢</div>
                    </div>
                </div>
            @endif
            
            @if( config('pw-config.system.apps.captcha') )
                <div class="form-group">
                    <label>{{ __('captcha.captcha') }}</label>
                    <x-slider-captcha />
                </div>
            @endif
            
            <button type="submit" class="auth-button">
                <span class="button-text">{{ __('auth.form.resetPassword') }}</span>
                <div class="loading-spinner"></div>
            </button>
            
            <div class="auth-link">
                <p>{{ __('auth.form.registered') }} <a href="{{ route('login') }}">{{ __('auth.back_to_login') }}</a></p>
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
            
            // Phoenix rebirth colors
            const colors = ['#ff6b6b', '#ff8e53', '#9370db', '#8a2be2'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
            particle.style.boxShadow = `0 0 10px ${color}`;
            
            particlesContainer.appendChild(particle);
        }
    }

    // Enhanced form interactions
    document.getElementById('resetForm').addEventListener('submit', function(e) {
        const button = document.querySelector('.auth-button');
        const buttonText = button.querySelector('.button-text');
        const spinner = button.querySelector('.loading-spinner');
        
        // Show loading state
        buttonText.style.display = 'none';
        spinner.style.display = 'block';
        button.disabled = true;
        button.style.transform = 'scale(0.95)';
        
        // Phoenix rebirth effect
        const phoenixes = document.querySelectorAll('.phoenix-ornament');
        phoenixes.forEach((phoenix, index) => {
            setTimeout(() => {
                phoenix.style.animation = 'phoenixRebirth 3s ease-out forwards';
            }, index * 500);
        });
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

    // Initialize particles
    createParticles();

    // Add phoenix rebirth animation
    const phoenixStyle = document.createElement('style');
    phoenixStyle.textContent = `
        @keyframes phoenixRebirth {
            0% { 
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.08;
            }
            50% {
                transform: translateY(-100px) rotate(180deg) scale(1.5);
                opacity: 1;
                color: #ff6b6b;
            }
            100% { 
                transform: translateY(0) rotate(360deg) scale(1);
                opacity: 0.08;
                color: #9370db;
            }
        }
    `;
    document.head.appendChild(phoenixStyle);

    // Add entrance animation
    window.addEventListener('load', function() {
        document.querySelector('.auth-container').style.animation = 'fadeInScale 1.5s ease-out';
    });
</script>
@endsection