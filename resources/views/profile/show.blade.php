<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('pw-config.server_name', 'Haven Perfect World') }} - {{ __('general.dashboard.profile.header') }}</title>
    
    @if( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
    @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
    @endif
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cinzel', serif;
            background: radial-gradient(ellipse at center, #2a1b3d 0%, #1a0f2e 50%, #0a0514 100%);
            color: #e6d7f0;
            min-height: 100vh;
            position: relative;
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
                radial-gradient(circle at 50% 50%, rgba(148, 0, 211, 0.08) 0%, transparent 50%);
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 8s infinite ease-in-out;
            box-shadow: 0 0 10px rgba(147, 112, 219, 0.5);
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            50% { 
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.7;
            }
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(147, 112, 219, 0.3);
            padding: 20px 60px 20px 40px; /* More padding on right to move content left */
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-title {
            font-size: 2rem;
            color: #9370db;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .home-button {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.2), rgba(138, 43, 226, 0.2));
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 10px 20px;
            color: #e6d7f0;
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .home-button:hover {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.3), rgba(138, 43, 226, 0.3));
            border-color: #9370db;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }

        .home-button i {
            font-size: 1.1rem;
        }

        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 100;
        }

        .balance-display {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.2), rgba(138, 43, 226, 0.2));
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
        }
        
        /* Style the actual avatar image */
        .user-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #9370db;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-avatar img:hover {
            border-color: #8a2be2;
            box-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }
        
        /* Style avatar button when no image */
        .user-avatar button {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.2), rgba(138, 43, 226, 0.2));
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 25px;
            padding: 8px 15px;
            color: #e6d7f0;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .user-avatar button:hover {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.3), rgba(138, 43, 226, 0.3));
            border-color: #9370db;
        }

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 10;
            max-width: 7xl;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Profile Sections */
        .profile-section {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(10px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .profile-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(147, 112, 219, 0.3);
        }

        .section-title {
            font-size: 1.5rem;
            color: #9370db;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.5);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(147, 112, 219, 0.5), transparent);
            margin: 40px 0;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #b19cd9;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            background: rgba(26, 15, 46, 0.6);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 10px;
            padding: 12px 15px;
            color: #e6d7f0;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 0 0 15px rgba(147, 112, 219, 0.4);
        }

        .btn-primary {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.5);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(147, 112, 219, 0.5);
            border-radius: 10px;
            padding: 12px 30px;
            color: #9370db;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-secondary:hover {
            background: rgba(147, 112, 219, 0.1);
            border-color: #9370db;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.5);
        }

        /* Character List */
        .character-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .character-card {
            background: rgba(26, 15, 46, 0.6);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .character-card:hover {
            transform: translateY(-5px);
            border-color: #9370db;
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.3);
        }

        .character-name {
            font-size: 1.2rem;
            color: #9370db;
            margin-bottom: 10px;
        }

        .character-info {
            color: #b19cd9;
            font-size: 0.9rem;
        }

        /* Dropdown Menu Styling */
        [x-cloak] { display: none !important; }
        
        /* Force dropdown to appear above everything */
        .user-info .relative {
            z-index: 999 !important;
        }
        
        .user-info [x-show] {
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        /* Override dropdown styles - clean white/dark background */
        div[x-show] {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            border-radius: 0.375rem !important;
            padding: 0.25rem 0 !important;
        }
        
        /* Dropdown links - dark text on white */
        div[x-show] a,
        div[x-show] button {
            display: block !important;
            padding: 0.5rem 1rem !important;
            color: #1f2937 !important;
            text-decoration: none !important;
            transition: background-color 0.15s !important;
            border: none !important;
            width: 100% !important;
            text-align: left !important;
            background: transparent !important;
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
            font-family: system-ui, -apple-system, sans-serif !important;
        }
        
        div[x-show] a:hover,
        div[x-show] button:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }
        
        /* Character selector styling */
        .character-selector {
            background: rgba(147, 112, 219, 0.2);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 8px 15px;
            color: #e6d7f0;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .character-selector-label {
            color: #b19cd9;
            font-size: 0.85rem;
            margin-right: 5px;
        }
        
        .character-selector button {
            background: transparent !important;
            border: none !important;
            color: #e6d7f0 !important;
            padding: 0 !important;
        }
        
        .character-selector:hover {
            background: rgba(147, 112, 219, 0.3);
            border-color: #9370db;
        }

        /* Fix icon sizes in forms */
        svg {
            max-width: 24px !important;
            max-height: 24px !important;
        }
        
        /* Fix large icons in browser sessions */
        .h-8.w-8, .h-10.w-10, .h-12.w-12 {
            height: 1.5rem !important;
            width: 1.5rem !important;
        }

        /* Override Tailwind/Livewire Styles */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            background: rgba(26, 15, 46, 0.6) !important;
            border: 1px solid rgba(147, 112, 219, 0.3) !important;
            border-radius: 10px !important;
            padding: 12px 15px !important;
            color: #e6d7f0 !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            border-color: #9370db !important;
            box-shadow: 0 0 15px rgba(147, 112, 219, 0.4) !important;
        }

        label {
            color: #b19cd9 !important;
            margin-bottom: 8px !important;
            font-size: 0.95rem !important;
        }

        /* Buttons in forms */
        button[type="submit"],
        .inline-flex.items-center.px-4.py-2 {
            background: linear-gradient(45deg, #9370db, #8a2be2) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px 30px !important;
            color: white !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        button[type="submit"]:hover,
        .inline-flex.items-center.px-4.py-2:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.5) !important;
        }

        /* Error messages */
        .text-red-600,
        .text-red-500 {
            color: #f87171 !important;
        }

        /* Success messages */
        .text-green-600,
        .text-green-500 {
            color: #86efac !important;
        }

        /* Section headers in Livewire components */
        h3 {
            color: #9370db !important;
            font-size: 1.5rem !important;
            margin-bottom: 1rem !important;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.5) !important;
        }

        /* Cards and panels */
        .bg-white,
        .dark\\:bg-gray-800 {
            background: transparent !important;
        }

        .shadow,
        .shadow-xl {
            box-shadow: none !important;
        }

        /* Text colors */
        .text-gray-600,
        .text-gray-700,
        .text-gray-800,
        .dark\\:text-gray-300,
        .dark\\:text-gray-400 {
            color: #b19cd9 !important;
        }

        /* Links */
        a:not(.home-button):not(.block) {
            color: #9370db !important;
            transition: all 0.3s ease !important;
        }

        a:not(.home-button):not(.block):hover {
            color: #8a2be2 !important;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.6) !important;
        }
        
        /* Fix avatar upload section */
        .col-span-6.sm\\:col-span-4:has(img[alt]) {
            max-width: fit-content !important;
        }
        
        /* Success message styling */
        .text-green-600 {
            background: rgba(34, 197, 94, 0.1) !important;
            border: 1px solid rgba(34, 197, 94, 0.3) !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            color: #86efac !important;
            display: inline-block !important;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            padding: 30px 40px;
            text-align: center;
            color: #b19cd9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 20px;
            }

            .header-title {
                font-size: 1.5rem;
            }

            .main-container {
                padding: 20px 10px;
            }

            .profile-section {
                padding: 20px;
            }

            .character-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <!-- Header -->
    <header class="header">
        <div style="display: flex; align-items: center; gap: 20px;">
            <h1 class="header-title">{{ __('general.dashboard.profile.header') }}</h1>
            <a href="{{ route('HOME') }}" class="home-button">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
        
        <div class="user-info">
            <div class="character-selector">
                <span class="character-selector-label">Character:</span>
                <x-hrace009::character-selector/>
            </div>
            
            <div class="balance-display">
                <x-hrace009::balance/>
            </div>
            
            <div class="user-avatar">
                <x-hrace009::user-avatar/>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="profile-section">
                @livewire('profile.update-profile-information-form')
            </div>
        @endif

        @if ( $api->online )
            <div class="profile-section">
                <h2 class="section-title">{{ __('My Characters') }}</h2>
                @livewire('profile.list-character')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="profile-section">
                @livewire('profile.update-password-form')
            </div>

            <div class="profile-section">
                @livewire('profile.pin-settings')
            </div>
        @endif

        <div class="profile-section">
            @livewire('profile.logout-from-other-browser')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="profile-section">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <x-hrace009::footer/>
    </footer>
    
    <script>
        // Create floating particles
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
                
                const colors = ['#9370db', '#8a2be2', '#4b0082', '#6a5acd'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();
        
        // Listen for Livewire saved event and refresh page
        document.addEventListener('DOMContentLoaded', function () {
            // For Livewire v2
            if (typeof Livewire !== 'undefined') {
                Livewire.on('saved', () => {
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                });
            }
            
            // For Livewire v3
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('saved', () => {
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                });
            });
        });
    </script>
    
    <x-hrace009::front.bottom-script/>
    @livewireScripts
</body>
</html>