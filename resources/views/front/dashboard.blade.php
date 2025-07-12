<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('pw-config.server_name', 'Haven Perfect World') }} - Dashboard</title>
    
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
            overflow-x: hidden;
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

        .dragon-ornament {
            position: absolute;
            font-size: 8rem;
            opacity: 0.1;
            color: #9370db;
            animation: dragonPulse 4s ease-in-out infinite;
            user-select: none;
        }

        .dragon-left {
            top: 20%;
            left: -5%;
            transform: rotate(-15deg);
        }

        .dragon-right {
            bottom: 20%;
            right: -5%;
            transform: rotate(15deg) scaleX(-1);
        }

        @keyframes dragonPulse {
            0%, 100% { opacity: 0.1; transform: scale(1) rotate(-15deg); }
            50% { opacity: 0.2; transform: scale(1.1) rotate(-10deg); }
        }

        .dashboard-container {
            position: relative;
            z-index: 10;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, rgba(26, 15, 46, 0.9), rgba(42, 27, 61, 0.9));
            backdrop-filter: blur(20px);
            border-right: 2px solid rgba(147, 112, 219, 0.4);
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(147, 112, 219, 0.3);
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #b19cd9;
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: rgba(147, 112, 219, 0.2);
            color: #d8c8e8;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.3), rgba(138, 43, 226, 0.3));
            color: #e6d7f0;
            border-left: 4px solid #9370db;
        }

        .nav-icon {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
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
        
        /* Override dropdown styles for purple theme */
        .bg-white.dark\\:bg-dark {
            background: linear-gradient(135deg, rgba(26, 15, 46, 0.95), rgba(75, 0, 130, 0.9)) !important;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            z-index: 9999 !important;
        }
        
        /* Dropdown links */
        .bg-white.dark\\:bg-dark a {
            color: #d8c8e8 !important;
            transition: all 0.3s ease;
        }
        
        .bg-white.dark\\:bg-dark a:hover {
            background: rgba(147, 112, 219, 0.2) !important;
            color: #e6d7f0 !important;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 30px;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(147, 112, 219, 0.05), transparent);
            animation: shimmerBg 4s ease-in-out infinite;
        }

        @keyframes shimmerBg {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #9370db;
            margin-bottom: 15px;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
            position: relative;
            z-index: 1;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #b19cd9;
            font-style: italic;
            position: relative;
            z-index: 1;
        }

        /* News Section */
        .news-section {
            background: linear-gradient(135deg, rgba(26, 15, 46, 0.6), rgba(75, 0, 130, 0.2));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            color: #e6d7f0;
        }

        .section-title {
            font-size: 1.8rem;
            color: #9370db;
            margin-bottom: 25px;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }
        
        .news-section a {
            color: #c8b3e0;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .news-section a:hover {
            color: #9370db;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.5);
        }
        
        .news-section p,
        .news-section div {
            color: #d8c8e8;
        }

        /* Widget Area */
        .widget-area {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 25px;
            position: sticky;
            top: 20px;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            color: #fff;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            padding: 30px 40px;
            text-align: center;
            color: #b19cd9;
        }

        @media (max-width: 1024px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                left: -280px;
                height: 100vh;
                z-index: 90;
                transition: left 0.3s ease;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .widget-area {
                position: static;
            }
        }
    </style>
    
    <x-hrace009::front.top-script/>
    
    <!-- Alpine.js and Livewire for components -->
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">{{ config('pw-config.server_name') }}</div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('app.dashboard') }}" class="nav-link {{ Route::is('app.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">🏠</span>
                        Dashboard
                    </a>
                </li>
                
                @if( config('pw-config.system.apps.shop') )
                <li class="nav-item">
                    <a href="{{ route('app.shop.index') }}" class="nav-link {{ Route::is('app.shop.*') ? 'active' : '' }}">
                        <span class="nav-icon">🛒</span>
                        Shop
                    </a>
                </li>
                @endif
                
                @if( config('pw-config.system.apps.donate') )
                <li class="nav-item">
                    <a href="{{ route('app.donate.history') }}" class="nav-link {{ Route::is('app.donate.*') ? 'active' : '' }}">
                        <span class="nav-icon">💎</span>
                        Donate
                    </a>
                </li>
                @endif
                
                @if( config('pw-config.system.apps.vote') )
                <li class="nav-item">
                    <a href="{{ route('app.vote.index') }}" class="nav-link {{ Route::is('app.vote.*') ? 'active' : '' }}">
                        <span class="nav-icon">⭐</span>
                        Vote
                    </a>
                </li>
                @endif
                
                @if( config('pw-config.system.apps.voucher') )
                <li class="nav-item">
                    <a href="{{ route('app.voucher.index') }}" class="nav-link {{ Route::is('app.voucher.*') ? 'active' : '' }}">
                        <span class="nav-icon">🎟️</span>
                        Voucher
                    </a>
                </li>
                @endif
                
                @if ( config('pw-config.system.apps.inGameService') )
                <li class="nav-item">
                    <a href="{{ route('app.services.index') }}" class="nav-link {{ Route::is('app.services.*') ? 'active' : '' }}">
                        <span class="nav-icon">⚔️</span>
                        Services
                    </a>
                </li>
                @endif
                
                @if( config('pw-config.system.apps.ranking') )
                <li class="nav-item">
                    <a href="{{ route('app.ranking.index') }}" class="nav-link {{ Route::is('app.ranking.*') ? 'active' : '' }}">
                        <span class="nav-icon">🏆</span>
                        Rankings
                    </a>
                </li>
                @endif
                
            </ul>
        </aside>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <h1 class="header-title">Dashboard</h1>
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
            
            <!-- Content -->
            <main class="content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h2 class="welcome-title">
                        Welcome, {{ Auth::user()->truename ?? Auth::user()->name }}!
                    </h2>
                    <p class="welcome-subtitle">
                        Embark on your journey in {{ config('pw-config.server_name') }}
                    </p>
                </div>
                
                <div class="content-grid">
                    <!-- News Section -->
                    <div class="news-section">
                        <h3 class="section-title">Latest News & Updates</h3>
                        <x-hrace009::front.news-view/>
                    </div>
                    
                    <!-- Widget Area -->
                    <div class="widget-area">
                        <x-hrace009::front.widget/>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="footer">
                <x-hrace009::footer/>
            </footer>
        </div>
    </div>
    
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

        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Initialize particles
        createParticles();
    </script>
    
    <x-hrace009::front.bottom-script/>
    @livewireScripts
</body>
</html>
