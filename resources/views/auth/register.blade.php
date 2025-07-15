<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('pw-config.server_name', 'Haven Perfect World') }} - Create Your Legend</title>
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
            overflow-x: hidden;
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

        .dragon-ornament {
            position: absolute;
            font-size: 12rem;
            opacity: 0.08;
            color: #9370db;
            animation: dragonPulse 5s ease-in-out infinite;
            user-select: none;
        }

        .dragon-left {
            top: 5%;
            left: -8%;
            transform: rotate(-20deg);
        }

        .dragon-right {
            bottom: 5%;
            right: -8%;
            transform: rotate(20deg) scaleX(-1);
        }

        @keyframes dragonPulse {
            0%, 100% { opacity: 0.08; transform: scale(1) rotate(-20deg); }
            50% { opacity: 0.15; transform: scale(1.05) rotate(-15deg); }
        }

        .register-container {
            position: relative;
            z-index: 3;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(75, 0, 130, 0.15));
            backdrop-filter: blur(25px);
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 25px;
            padding: 40px 35px;
            width: 500px;
            max-width: 90vw;
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(147, 112, 219, 0.3);
            position: relative;
            overflow: hidden;
            max-height: 90vh;
            overflow-y: auto;
        }

        .register-container::-webkit-scrollbar {
            width: 8px;
        }

        .register-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }

        .register-container::-webkit-scrollbar-thumb {
            background: rgba(147, 112, 219, 0.5);
            border-radius: 4px;
        }

        .register-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(147, 112, 219, 0.08), transparent);
            animation: shimmerBg 6s ease-in-out infinite;
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
            background: linear-gradient(45deg, #9370db, transparent, #8a2be2, transparent);
            background-size: 300% 300%;
            animation: rotateBorder 12s linear infinite;
            opacity: 0.4;
        }

        @keyframes rotateBorder {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #dda0dd, #9370db);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease-in-out infinite;
            text-shadow: 0 0 40px rgba(147, 112, 219, 0.8);
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .tagline {
            font-size: 1.8rem;
            color: #dda0dd;
            margin-bottom: 25px;
            font-style: italic;
            text-shadow: 0 0 15px rgba(221, 160, 221, 0.5);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .register-form {
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #dda0dd;
            font-weight: 600;
            font-size: 0.95rem;
            text-shadow: 0 0 10px rgba(221, 160, 221, 0.6);
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(147, 112, 219, 0.5);
            border-radius: 15px;
            color: #e6d7ff;
            font-size: 0.95rem;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            text-transform: none !important;
            font-variant: normal !important;
        }

        .form-group input:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 
                0 0 20px rgba(147, 112, 219, 0.4),
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
            background: linear-gradient(90deg, #9370db, #8a2be2);
            transition: width 0.3s ease;
        }

        .form-group:focus-within::after {
            width: 100%;
        }

        .register-button {
            width: 100%;
            background: linear-gradient(45deg, #9370db, #8a2be2, #4b0082);
            background-size: 300% 300%;
            color: #ffffff;
            border: none;
            padding: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: buttonGlow 3s ease-in-out infinite alternate;
            font-family: 'Cinzel', serif;
            margin-top: 25px;
            margin-bottom: 20px;
        }

        @keyframes buttonGlow {
            0% { 
                box-shadow: 0 5px 25px rgba(147, 112, 219, 0.4);
                background-position: 0% 50%;
            }
            100% { 
                box-shadow: 0 8px 35px rgba(138, 43, 226, 0.6);
                background-position: 100% 50%;
            }
        }

        .register-button:hover {
            transform: translateY(-3px);
            background-position: 100% 50%;
            box-shadow: 0 15px 45px rgba(147, 112, 219, 0.8);
        }

        .register-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .register-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .form-check input[type="checkbox"] {
            margin-right: 10px;
            margin-top: 4px;
            accent-color: #9370db;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check label {
            color: #dda0dd;
            font-size: 0.85rem;
            line-height: 1.4;
            cursor: pointer;
        }

        .form-check label a {
            color: #9370db;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .form-check label a:hover {
            color: #dda0dd;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.6);
        }

        .login-link {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .login-link a {
            color: #dda0dd;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border-bottom: 1px solid transparent;
        }

        .login-link a:hover {
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
            font-size: 0.85rem;
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

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9370db;
            font-size: 1.1rem;
            opacity: 0.7;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .form-group:focus-within .input-icon {
            opacity: 1;
            color: #dda0dd;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 30px 25px;
                width: 95vw;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .tagline {
                font-size: 1.5rem;
            }
            
            .dragon-ornament {
                font-size: 8rem;
            }
        }

        .epic-glow {
            animation: epicGlow 4s ease-in-out infinite alternate;
        }

        @keyframes epicGlow {
            0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
            100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
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
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="register-container">
        <div class="mystical-border"></div>
        
        <div class="header">
            <p class="tagline">{{ __('auth.create_legend') }}</p>
        </div>

        <form class="register-form" method="POST" action="{{ route('register') }}" id="registerForm">
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
                        @captcha
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
            
            <button type="submit" class="register-button">
                <span class="button-text">Begin Your Journey</span>
                <div class="loading-spinner"></div>
            </button>
            
            <div class="login-link">
                <p>{{ __('auth.already_account') }} <a href="{{ route('login') }}">{{ __('auth.login_here') }}</a></p>
            </div>
        </form>
    </div>

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
            const button = document.querySelector('.register-button');
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
            document.querySelector('.register-container').style.animation = 'fadeInScale 1.5s ease-out';
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