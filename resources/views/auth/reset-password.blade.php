<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('pw-config.server_name', 'Laravel') }} - {{ __('auth.form.resetPassword') }}</title>
    <meta name="description" content="Reset password for {{ config('pw-config.server_name') }}">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/portal/bootstrap/dist/css/bootstrap.min.css') }}" />
    {{-- FontAwesome for icons --}}
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fontawesome-all.min.js') }}"></script>
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fa-v4-shims.min.js') }}"></script>
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom-home.css') }}">

    @php
        $userTheme = auth()->check() ? auth()->user()->theme : config('themes.default');
        $themeConfig = config('themes.themes.' . $userTheme);
    @endphp
    
    @if($themeConfig && isset($themeConfig['css']))
        <link rel="stylesheet" href="{{ asset($themeConfig['css']) }}">
    @endif

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        /* Modern Dark Theme Variables */
        :root {
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a3a;
            --bg-tertiary: #2a2a4a;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #334155;
            --card-bg: #1e293b;
            --hover-bg: rgba(99, 102, 241, 0.1);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-20px, -20px) scale(1.02); }
            66% { transform: translate(20px, -10px) scale(0.98); }
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Styles */
        .login-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 48px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: var(--gradient-accent);
            border-radius: 24px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .login-card:hover::before {
            opacity: 0.1;
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: var(--gradient-accent);
            border-radius: 20px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
        }

        .logo-wrapper:hover {
            transform: scale(1.05);
        }

        .logo-wrapper i {
            font-size: 36px;
            color: white;
        }

        .server-name {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 16px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            background: var(--bg-tertiary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-primary);
            background: var(--bg-secondary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* Button Styles */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--gradient-accent);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: var(--shadow-md);
            margin-top: 32px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Link Styles */
        .form-link {
            color: var(--accent-primary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .form-link:hover {
            color: var(--accent-secondary);
            text-decoration: underline;
        }

        .back-to-login {
            text-align: center;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid var(--border-color);
        }

        /* Alert Styles */
        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        /* Validation Errors */
        .validation-errors {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .validation-errors ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .validation-errors li {
            color: #ef4444;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .validation-errors li:last-child {
            margin-bottom: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .server-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Language Selector -->
    @include('partials.language-selector')
    
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="server-name">{{ config('pw-config.server_name', 'PW Panel') }}</h1>
                <p class="login-subtitle">{{ __('auth.form.resetPassword') }}</p>
            </div>

            @if ($errors->any())
                <div class="validation-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input type="hidden" name="email" value="{{ $request->email }}">

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="new-password" autofocus 
                           placeholder="Enter your new password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input id="password_confirmation" type="password" class="form-control" 
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Confirm your new password">
                </div>

                @php
                    $user = \App\Models\User::where('email', $request->email)->first();
                    $showPinFields = !Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()) 
                                    && $user 
                                    && $user->pin_enabled;
                @endphp
                
                @if ($showPinFields)
                    <div class="form-group">
                        <label for="pin" class="form-label">New PIN</label>
                        <input id="pin" type="password" class="form-control @error('pin') is-invalid @enderror" 
                               name="pin" required placeholder="Enter your new PIN">
                    </div>

                    <div class="form-group">
                        <label for="pin_confirmation" class="form-label">Confirm New PIN</label>
                        <input id="pin_confirmation" type="password" class="form-control" 
                               name="pin_confirmation" required placeholder="Confirm your new PIN">
                    </div>
                @endif

                @if( config('pw-config.system.apps.captcha') )
                    <div class="form-group">
                        <x-hrace009::captcha/>
                    </div>
                @endif

                <button type="submit" class="btn-login">
                    <i class="fas fa-sync-alt mr-2"></i>{{ __('auth.form.resetPassword') }}
                </button>
            </form>

            <div class="back-to-login">
                <a href="{{ route('login') }}" class="form-link">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/portal/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>
</html>