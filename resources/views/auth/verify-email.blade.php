@extends('layouts.auth')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - Verify Your Email')

@section('body-class', 'verify-email-page')

@section('content')
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="auth-container verify-container">
        <div class="mystical-border"></div>
        
        <div class="auth-header">
            <h1 class="auth-tagline">{{ __('Verify Your Email') }}</h1>
        </div>

        <div class="verify-content">
            <div class="verify-icon">✉️</div>
            
            <p class="verify-message">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
            </p>
            
            <p class="verify-message">
                {{ __('If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="success-message">
                    <span class="success-icon">✓</span>
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="verify-actions">
                <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
                    @csrf
                    <button type="submit" class="auth-button resend-button">
                        <span class="button-text">{{ __('Resend Verification Email') }}</span>
                        <div class="loading-spinner"></div>
                    </button>
                </form>

                <div class="or-divider">
                    <span>or</span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="text-button">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
/* Verify Email Page Specific Styles */
.verify-container {
    width: 500px;
    padding: 40px;
}

.verify-content {
    text-align: center;
}

.verify-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    animation: mailFloat 3s ease-in-out infinite;
}

@keyframes mailFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.verify-message {
    color: #dda0dd;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
    text-shadow: 0 0 10px rgba(221, 160, 221, 0.3);
}

.success-message {
    background: rgba(50, 205, 50, 0.1);
    border: 1px solid rgba(50, 205, 50, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin: 20px 0;
    color: #32cd32;
    display: flex;
    align-items: center;
    gap: 10px;
}

.success-icon {
    font-size: 1.5rem;
}

.verify-actions {
    margin-top: 30px;
}

.resend-form {
    margin-bottom: 20px;
}

.resend-button {
    width: 100%;
}

.or-divider {
    position: relative;
    margin: 20px 0;
    color: #9370db;
    font-size: 0.9rem;
}

.or-divider::before,
.or-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 40%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.5), transparent);
}

.or-divider::before {
    left: 0;
}

.or-divider::after {
    right: 0;
}

.text-button {
    background: none;
    border: none;
    color: #dda0dd;
    text-decoration: underline;
    cursor: pointer;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    font-family: 'Cinzel', serif;
}

.text-button:hover {
    color: #9370db;
    text-shadow: 0 0 10px rgba(147, 112, 219, 0.6);
}
</style>

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

    // Form submission handling
    document.querySelector('.resend-form').addEventListener('submit', function(e) {
        const button = this.querySelector('.auth-button');
        const buttonText = button.querySelector('.button-text');
        const spinner = button.querySelector('.loading-spinner');
        
        buttonText.style.display = 'none';
        spinner.style.display = 'block';
        button.disabled = true;
    });

    // Initialize particles
    createParticles();
</script>
@endsection