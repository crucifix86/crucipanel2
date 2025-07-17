@extends('layouts.auth')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - Restore Your Path')

@section('body-class', 'forgot-password-page')

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
            <p class="auth-tagline">{{ __('auth.restore_path') }}</p>
        </div>

        <form class="auth-form" method="POST" action="{{ route('password.email') }}" id="forgotForm">
            @csrf
            
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <div class="form-description">
                {{ __('auth.form.forgotPasswordDescription') }}
            </div>

            <div class="form-group">
                <label for="email">{{ __('auth.form.email') }}</label>
                <input type="email" id="email" name="email" placeholder="{{ __('auth.enter_email') }}" 
                       value="{{ old('email') }}" required autofocus autocomplete="email">
                <div class="input-icon">✉️</div>
            </div>
            
            @if( config('pw-config.system.apps.captcha') )
                <div class="form-group">
                    <label for="captcha">{{ __('captcha.captcha') }}</label>
                    <div class="captcha-wrapper">
                        @captcha
                    </div>
                    <input type="text" id="captcha" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    <div class="input-icon">🛡️</div>
                </div>
            @endif
            
            <button type="submit" class="auth-button">
                <span class="button-text">{{ __('auth.form.sendLinkPassword') }}</span>
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
            
            // Phoenix fire colors
            const colors = ['#ff6b6b', '#ff8e53', '#fe6b8b', '#ff6090'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
            particle.style.boxShadow = `0 0 10px ${color}`;
            
            particlesContainer.appendChild(particle);
        }
    }

    // Enhanced form interactions
    document.getElementById('forgotForm').addEventListener('submit', function(e) {
        const button = document.querySelector('.auth-button');
        const buttonText = button.querySelector('.button-text');
        const spinner = button.querySelector('.loading-spinner');
        
        // Show loading state
        buttonText.style.display = 'none';
        spinner.style.display = 'block';
        button.disabled = true;
        button.style.transform = 'scale(0.95)';
        
        // Phoenix rise effect
        const phoenixes = document.querySelectorAll('.phoenix-ornament');
        phoenixes.forEach(phoenix => {
            phoenix.style.animation = 'phoenixRiseFast 2s ease-out forwards';
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

    // Add phoenix rise animation
    const phoenixStyle = document.createElement('style');
    phoenixStyle.textContent = `
        @keyframes phoenixRiseFast {
            0% { 
                transform: translateY(0) scale(1);
                opacity: 0.08;
            }
            100% { 
                transform: translateY(-200px) scale(1.5);
                opacity: 0.8;
                color: #ff6b6b;
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