<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('pw-config.server_name', 'Haven Perfect World') }} - Restore Your Path</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cinzel', serif;
            background: radial-gradient(ellipse at center, #1a0d26 0%, #0f0518 50%, #080313 100%);
            color: #e6d7ff;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mystical-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            background: 
                radial-gradient(circle at 20% 30%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(75, 0, 130, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 50% 20%, rgba(147, 112, 219, 0.08) 0%, transparent 50%);
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 10s infinite ease-in-out;
            box-shadow: 0 0 8px rgba(147, 112, 219, 0.6);
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            50% { 
                transform: translateY(-120px) rotate(180deg);
                opacity: 0.8;
            }
        }

        .phoenix-ornament {
            position: absolute;
            font-size: 12rem;
            opacity: 0.08;
            color: #dda0dd;
            animation: phoenixRise 8s ease-in-out infinite;
            user-select: none;
        }

        .phoenix-left {
            top: 15%;
            left: -5%;
            transform: rotate(-15deg);
        }

        .phoenix-right {
            bottom: 15%;
            right: -5%;
            transform: rotate(15deg) scaleX(-1);
        }

        @keyframes phoenixRise {
            0%, 100% { 
                opacity: 0.08; 
                transform: translateY(0) rotate(-15deg); 
            }
            50% { 
                opacity: 0.2; 
                transform: translateY(-30px) rotate(-10deg); 
            }
        }

        .reset-container {
            position: relative;
            z-index: 3;
            background: linear-gradient(135deg, rgba(221, 160, 221, 0.15), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(25px);
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 25px;
            padding: 50px 40px;
            width: 450px;
            max-width: 90vw;
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(147, 112, 219, 0.3);
            position: relative;
            overflow: hidden;
        }

        .reset-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(221, 160, 221, 0.05), transparent);
            animation: shimmerBg 8s ease-in-out infinite;
        }

        @keyframes shimmerBg {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .mystical-border {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            border: 2px solid transparent;
            border-radius: 50%;
            background: linear-gradient(45deg, #dda0dd, transparent, #9370db, transparent);
            background-size: 300% 300%;
            animation: rotateBorder 15s linear infinite;
            opacity: 0.3;
        }

        @keyframes rotateBorder {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            position: relative;
            z-index: 1;
        }

        .tagline {
            font-size: 2rem;
            color: #dda0dd;
            margin-bottom: 20px;
            font-style: italic;
            text-shadow: 0 0 20px rgba(221, 160, 221, 0.6);
            font-weight: 600;
            letter-spacing: 1px;
            animation: mysticGlow 4s ease-in-out infinite alternate;
        }

        @keyframes mysticGlow {
            0% { text-shadow: 0 0 20px rgba(221, 160, 221, 0.6); }
            100% { text-shadow: 0 0 40px rgba(221, 160, 221, 0.9), 0 0 60px rgba(147, 112, 219, 0.6); }
        }

        .info-text {
            color: rgba(230, 215, 255, 0.8);
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 30px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
            font-family: Arial, sans-serif;
        }

        .reset-form {
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #dda0dd;
            font-weight: 600;
            font-size: 1rem;
            text-shadow: 0 0 10px rgba(221, 160, 221, 0.6);
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(147, 112, 219, 0.5);
            border-radius: 15px;
            color: #e6d7ff;
            font-size: 1rem;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            text-transform: none !important;
            font-variant: normal !important;
        }

        .form-group input:focus {
            outline: none;
            border-color: #dda0dd;
            box-shadow: 
                0 0 25px rgba(221, 160, 221, 0.5),
                inset 0 0 20px rgba(147, 112, 219, 0.1);
            background: rgba(0, 0, 0, 0.6);
        }

        .form-group input::placeholder {
            color: rgba(221, 160, 221, 0.6);
            font-style: italic;
        }

        .form-group::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #dda0dd, #9370db);
            transition: width 0.3s ease;
        }

        .form-group:focus-within::after {
            width: 100%;
        }

        .reset-button {
            width: 100%;
            background: linear-gradient(45deg, #dda0dd, #9370db, #8a2be2);
            background-size: 300% 300%;
            color: #ffffff;
            border: none;
            padding: 18px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: buttonShimmer 4s ease-in-out infinite;
            font-family: 'Cinzel', serif;
            margin-bottom: 20px;
        }

        @keyframes buttonShimmer {
            0% { 
                box-shadow: 0 5px 25px rgba(221, 160, 221, 0.4);
                background-position: 0% 50%;
            }
            50% { 
                box-shadow: 0 8px 35px rgba(147, 112, 219, 0.6);
                background-position: 100% 50%;
            }
            100% { 
                box-shadow: 0 5px 25px rgba(221, 160, 221, 0.4);
                background-position: 0% 50%;
            }
        }

        .reset-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 45px rgba(221, 160, 221, 0.8);
        }

        .reset-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .reset-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .back-link {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .back-link a {
            color: #dda0dd;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            border-bottom: 1px solid transparent;
        }

        .back-link a:hover {
            color: #9370db;
            border-bottom-color: #9370db;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            animation: errorShake 0.5s ease-out;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }

        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .success-message {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #63ff90;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            text-align: center;
            animation: successPulse 2s ease-in-out infinite;
        }

        @keyframes successPulse {
            0%, 100% { box-shadow: 0 0 10px rgba(40, 167, 69, 0.3); }
            50% { box-shadow: 0 0 20px rgba(40, 167, 69, 0.6); }
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #dda0dd;
            font-size: 1.2rem;
            opacity: 0.7;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .form-group:focus-within .input-icon {
            opacity: 1;
            color: #9370db;
        }

        @media (max-width: 768px) {
            .reset-container {
                padding: 30px 25px;
                width: 95vw;
            }
            
            .tagline {
                font-size: 1.6rem;
            }
            
            .phoenix-ornament {
                font-size: 8rem;
            }
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .button-text {
            display: inline-block;
        }

        .captcha-wrapper {
            margin-bottom: 10px;
            text-align: center;
        }

        .captcha-wrapper img {
            border-radius: 8px;
            border: 2px solid rgba(147, 112, 219, 0.5);
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="phoenix-ornament phoenix-left">🦅</div>
    <div class="phoenix-ornament phoenix-right">🦅</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="reset-container">
        <div class="mystical-border"></div>
        
        <div class="header">
            <p class="tagline">Restore Your Path</p>
        </div>

        <div class="info-text">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        <form class="reset-form" method="POST" action="{{ route('password.email') }}" id="resetForm">
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
                <label for="email">{{ __('auth.form.email') }}</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" 
                       value="{{ old('email') }}" required autofocus autocomplete="email">
                <div class="input-icon">✉️</div>
            </div>
            
            @if( config('pw-config.system.apps.captcha') )
                <div class="form-group">
                    <label for="captcha">Verification Code</label>
                    <div class="captcha-wrapper">
                        @captcha
                    </div>
                    <input type="text" id="captcha" name="captcha" placeholder="{{ __('captcha.enter_code') }}" required>
                    <div class="input-icon">🛡️</div>
                </div>
            @endif
            
            <button type="submit" class="reset-button">
                <span class="button-text">{{ __('auth.form.sendLinkPassword') }}</span>
                <div class="loading-spinner"></div>
            </button>
            
            <div class="back-link">
                <p><a href="{{ route('login') }}">Back to Login</a></p>
            </div>
        </form>
    </div>

    <script>
        // Create floating mystical particles
        function createParticles() {
            const particlesContainer = document.querySelector('.floating-particles');
            const numberOfParticles = 50;

            for (let i = 0; i < numberOfParticles; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = 100 + '%';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.animationDuration = (Math.random() * 8 + 8) + 's';
                
                // Use warmer colors for reset page
                const colors = ['#dda0dd', '#9370db', '#8a2be2', '#ff6ec7'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Enhanced reset form interactions
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const button = document.querySelector('.reset-button');
            const buttonText = button.querySelector('.button-text');
            const spinner = button.querySelector('.loading-spinner');
            
            // Show loading state
            buttonText.style.display = 'none';
            spinner.style.display = 'block';
            button.disabled = true;
            button.style.background = 'linear-gradient(45deg, #32cd32, #00ff7f)';
            button.style.transform = 'scale(0.95)';
            
            // Create healing light effect
            const rect = button.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            for (let i = 0; i < 8; i++) {
                setTimeout(() => {
                    const light = document.createElement('div');
                    light.style.cssText = `
                        position: fixed;
                        left: ${centerX}px;
                        top: ${centerY}px;
                        width: 10px;
                        height: 10px;
                        background: radial-gradient(circle, rgba(221,160,221,0.8), transparent);
                        border-radius: 50%;
                        pointer-events: none;
                        animation: healingLight 2s ease-out forwards;
                        z-index: 9999;
                    `;
                    document.body.appendChild(light);
                    setTimeout(() => light.remove(), 2000);
                }, i * 150);
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

        // Add healing light animation
        const healingStyle = document.createElement('style');
        healingStyle.textContent = `
            @keyframes healingLight {
                0% {
                    transform: translate(-50%, -50%) scale(0);
                    opacity: 1;
                }
                100% {
                    transform: translate(-50%, -50%) scale(40);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(healingStyle);

        // Add entrance animation
        window.addEventListener('load', function() {
            document.querySelector('.reset-container').style.animation = 'fadeInScale 1.5s ease-out';
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
</body>
</html>