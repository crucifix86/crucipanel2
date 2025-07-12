<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - {{ config('pw-config.server_name', 'Haven Perfect World') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            z-index: 2;
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

        .container {
            position: relative;
            z-index: 3;
            max-width: 900px;
            margin-left: 280px;
            margin-right: auto;
            padding: 20px;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .container {
                margin-left: 0;
                max-width: 100%;
            }
        }

        nav.nav-bar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1)) !important;
            background-color: transparent !important;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3) !important;
            border-radius: 20px;
            padding: 15px 20px;
            margin-bottom: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 10;
            max-width: 100%;
            box-sizing: border-box;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #b19cd9;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
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
            color: #fff;
            background: rgba(147, 112, 219, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }

        .nav-link.active {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            box-shadow: 0 8px 30px rgba(138, 43, 226, 0.6);
        }

        /* Dropdown Styles */
        .nav-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .dropdown-arrow {
            font-size: 0.8rem;
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .nav-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            min-width: 200px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            padding: 10px 0;
            margin-top: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            visibility: hidden;
            pointer-events: none;
        }

        .nav-dropdown.active .dropdown-menu {
            display: block;
            visibility: visible;
            pointer-events: auto;
        }

        .dropdown-item {
            display: block;
            padding: 10px 20px;
            color: #b19cd9;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .dropdown-item:hover {
            color: #fff;
            background: rgba(147, 112, 219, 0.3);
            padding-left: 25px;
        }

        .content-section {
            padding: 30px 0;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            color: #9370db;
            margin-bottom: 30px;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
        }

        .members-section {
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-title {
            font-size: 1.8rem;
            color: #b19cd9;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .members-list {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .members-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .members-table th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid rgba(147, 112, 219, 0.3);
            color: #e6d7f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 1px;
            background: rgba(147, 112, 219, 0.2);
        }
        
        .members-table td {
            padding: 15px 10px;
            border-bottom: 1px solid rgba(147, 112, 219, 0.1);
            color: #e6d7f0;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .members-table tr:hover {
            background: rgba(147, 112, 219, 0.1);
        }
        
        .member-list-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
            border: 2px solid rgba(147, 112, 219, 0.3);
        }
        
        .member-list-name {
            font-weight: 600;
            color: #e6d7f0;
        }
        
        .discord-list-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #7289da;
            font-size: 0.9rem;
            text-transform: none !important;
            font-variant: normal !important;
            font-family: Arial, 'Helvetica Neue', sans-serif !important;
        }
        
        .no-discord-list {
            color: #666;
            font-style: italic;
            font-size: 0.85rem;
        }

        .member-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(147, 112, 219, 0.4);
            border-color: #9370db;
        }

        .member-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 10px;
            border: 3px solid #9370db;
            box-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .member-name {
            font-size: 1.1rem;
            color: #e6d7f0;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .member-role {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .role-admin {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.4);
        }

        .role-gm {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }

        .role-member {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: white;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.4);
        }

        .member-info {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 5px;
        }

        .discord-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #7289da;
            font-size: 0.95rem;
            margin-top: 10px;
            text-transform: none !important;
            font-variant: normal !important;
            font-family: Arial, 'Helvetica Neue', sans-serif !important;
        }

        .discord-icon {
            width: 20px;
            height: 20px;
        }

        .no-discord {
            color: #666;
            font-style: italic;
            font-size: 0.85rem;
        }

        .footer {
            padding: 40px 0;
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            margin-top: 60px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-radius: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-left {
            text-align: left;
            padding-left: 40px;
            padding-right: 40px;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: right;
            padding-left: 40px;
            padding-right: 40px;
        }

        .footer-text {
            font-size: 1.1rem;
            color: #b19cd9;
            margin-bottom: 20px;
        }

        /* Server Status */
        .server-status {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 9999;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 10px 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 220px;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        .status-indicator.online .status-dot {
            background: #10b981;
            box-shadow: 0 0 10px #10b981;
        }
        
        .status-indicator.offline .status-dot {
            background: #ef4444;
            box-shadow: 0 0 10px #ef4444;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        .status-text {
            color: #e6d7f0;
            font-size: 0.95rem;
        }
        
        .players-online {
            color: #b19cd9;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .players-online i {
            color: #9370db;
            font-size: 0.9rem;
        }
        
        /* Login Box Container */
        .login-box-wrapper {
            position: fixed;
            top: 100px;
            left: 20px;
            z-index: 9998;
            width: 220px;
        }
        
        /* Login Box */
        .login-box {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .login-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid rgba(147, 112, 219, 0.3);
            cursor: pointer;
        }
        
        .login-box-header h3 {
            margin: 0;
            color: #9370db;
            font-size: 1rem;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }
        
        .collapse-toggle {
            background: none;
            border: none;
            color: #b19cd9;
            font-size: 0.9rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 3px;
        }
        
        .collapse-toggle:hover {
            color: #9370db;
        }
        
        .login-box.collapsed .collapse-toggle {
            transform: rotate(180deg);
        }
        
        .login-box-content {
            padding: 15px;
            max-height: 300px;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        
        .login-box.collapsed .login-box-content {
            max-height: 0;
            padding: 0 15px;
        }

        .login-box-content h3 {
            color: #9370db;
            font-size: 1.1rem;
            margin-bottom: 15px;
            text-align: center;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        .login-form input {
            width: 100%;
            padding: 8px 12px;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(147, 112, 219, 0.5);
            border-radius: 8px;
            color: #e6d7f0;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-family: Arial, sans-serif;
        }

        .login-form input::placeholder {
            color: rgba(177, 156, 217, 0.7);
        }

        .login-form input:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 0 0 15px rgba(147, 112, 219, 0.5);
        }

        .login-button {
            width: 100%;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            border: none;
            padding: 8px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 8px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .login-links {
            text-align: center;
            margin-top: 10px;
        }

        .login-links a {
            color: #b19cd9;
            text-decoration: none;
            font-size: 0.85rem;
            margin: 0 8px;
            transition: color 0.3s ease;
        }

        .login-links a:hover {
            color: #dda0dd;
            text-decoration: underline;
        }

        .user-info {
            text-align: center;
            color: #b19cd9;
        }

        .user-name {
            font-size: 0.95rem;
            color: #9370db;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .user-links {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .user-link {
            background: rgba(147, 112, 219, 0.2);
            border: 1px solid rgba(147, 112, 219, 0.4);
            color: #e6d7f0;
            padding: 6px 8px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .user-link:hover {
            background: rgba(147, 112, 219, 0.3);
            border-color: #9370db;
            transform: translateY(-2px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 0;
            position: relative;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .logo-container {
            position: relative;
            display: inline-block;
        }

        .logo {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 50px rgba(147, 112, 219, 0.8);
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .tagline {
            font-size: 1.2rem;
            color: #b19cd9;
            margin-bottom: 20px;
            font-style: italic;
            text-shadow: 0 0 15px rgba(177, 156, 217, 0.5);
        }

        .mystical-border {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150%;
            height: 150%;
            border: 2px solid transparent;
            border-radius: 50%;
            background: linear-gradient(45deg, #9370db, transparent, #4b0082, transparent);
            background-size: 300% 300%;
            animation: rotateBorder 8s linear infinite;
            opacity: 0.3;
        }

        @keyframes rotateBorder {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        /* Header Alignment Classes */
        .header-left {
            text-align: left;
            padding-left: 40px;
        }
        
        .header-center {
            text-align: center;
        }
        
        .header-right {
            text-align: right;
            padding-right: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .members-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .nav-link {
                font-size: 1rem;
                padding: 8px 15px;
            }
            
            .members-list {
                padding: 20px;
                overflow-x: auto;
            }
            
            .members-table {
                min-width: 500px;
            }
            
            .members-table th,
            .members-table td {
                padding: 10px 5px;
                font-size: 0.9rem;
            }
            
            .member-list-avatar {
                width: 30px;
                height: 30px;
            }
        }
    </style>
    @livewireStyles
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    @php
        $api = new \hrace009\PerfectWorldAPI\API();
        $point = new \App\Models\Point();
        $onlinePlayer = $point->getOnlinePlayer();
        $onlineCount = $api->online ? ($onlinePlayer >= 100 ? $onlinePlayer + config('pw-config.fakeonline', 0) : $onlinePlayer) : 0;
    @endphp
    
    <!-- Server Status -->
    <div class="server-status">
        <div class="status-indicator {{ $api->online ? 'online' : 'offline' }}">
            <span class="status-dot"></span>
            <span class="status-text">Server {{ $api->online ? 'Online' : 'Offline' }}</span>
        </div>
        @if($api->online)
            <div class="players-online">
                <i class="fas fa-users"></i> {{ $onlineCount }} {{ $onlineCount == 1 ? 'Player' : 'Players' }} Online
            </div>
        @endif
    </div>
    
    <!-- Login/User Box -->
    <div class="login-box-wrapper">
        <div class="login-box collapsed" id="loginBox">
            <div class="login-box-header" onclick="toggleLoginBox()">
                <h3>@if(Auth::check()) Account @else Member Login @endif</h3>
                <button class="collapse-toggle">▼</button>
            </div>
            <div class="login-box-content">
                @if(Auth::check())
                    <div class="user-info">
                        <h3>Welcome Back!</h3>
                        <div class="user-name">{{ Auth::user()->truename ?? Auth::user()->name }}</div>
                        <div class="user-links">
                            <a href="{{ route('app.dashboard') }}" class="user-link">My Dashboard</a>
                            <a href="{{ route('profile.show') }}" class="user-link">My Profile</a>
                            @if(Auth::user()->isAdministrator())
                            <a href="{{ route('admin.dashboard') }}" class="user-link">Admin Panel</a>
                            @endif
                            @if(Auth::user()->isGamemaster())
                            <a href="{{ route('gm.dashboard') }}" class="user-link">GM Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="login-button">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <h3>Member Login</h3>
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <input type="text" name="name" placeholder="Username" required autofocus>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="pin" placeholder="PIN (if required)" id="pin-field" style="display: none;">
                        <button type="submit" class="login-button">Login</button>
                    </form>
                    <div class="login-links">
                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('password.request') }}">Forgot?</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="container">
        
        @php
            $headerSettings = \App\Models\HeaderSetting::first();
            $headerContent = $headerSettings ? $headerSettings->content : '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>';
            $headerAlignment = $headerSettings ? $headerSettings->alignment : 'center';
        @endphp
        
        <div class="header header-{{ $headerAlignment }}">
            <div class="mystical-border"></div>
            <a href="{{ route('HOME') }}" style="text-decoration: none; color: inherit;">
                {!! $headerContent !!}
            </a>
        </div>

        <nav class="nav-bar">
            <div class="nav-links">
                <a href="{{ route('HOME') }}" class="nav-link {{ Route::is('HOME') ? 'active' : '' }}">Home</a>
                
                @if( config('pw-config.system.apps.shop') )
                <a href="{{ route('public.shop') }}" class="nav-link {{ Route::is('public.shop') ? 'active' : '' }}">Shop</a>
                @endif
                
                @if( config('pw-config.system.apps.donate') )
                <a href="{{ route('public.donate') }}" class="nav-link {{ Route::is('public.donate') ? 'active' : '' }}">Donate</a>
                @endif
                
                @if( config('pw-config.system.apps.ranking') )
                <a href="{{ route('public.rankings') }}" class="nav-link {{ Route::is('public.rankings') ? 'active' : '' }}">Rankings</a>
                @endif
                
                @if( config('pw-config.system.apps.vote') )
                <a href="{{ route('public.vote') }}" class="nav-link {{ Route::is('public.vote') ? 'active' : '' }}">Vote</a>
                @endif
                
                @php
                    $pages = \App\Models\Page::where('active', true)->orderBy('title')->get();
                @endphp
                @if($pages->count() > 0)
                    <div class="nav-dropdown">
                        <a href="#" class="nav-link dropdown-toggle" onclick="event.preventDefault(); this.parentElement.classList.toggle('active');">
                            Pages <span class="dropdown-arrow">▼</span>
                        </a>
                        <div class="dropdown-menu">
                            @foreach($pages as $page)
                                <a href="{{ route('page.show', $page->slug) }}" class="dropdown-item">{{ $page->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <a href="{{ route('public.members') }}" class="nav-link {{ Route::is('public.members') ? 'active' : '' }}">Members</a>
            </div>
        </nav>
        
        <div class="content-section">
        <h1 class="page-title">Community Members</h1>
        
        @if(count($gms) > 0)
        <div class="members-section">
            <h2 class="section-title">Staff Members</h2>
            <div class="members-grid">
                @foreach($gms as $gm)
                <div class="member-card">
                    <img src="{{ $gm->profile_photo_url }}" alt="{{ $gm->truename ?? $gm->name }}" class="member-avatar">
                    <h3 class="member-name">{{ $gm->truename ?? $gm->name }}</h3>
                    <span class="member-role {{ $gm->isAdministrator() ? 'role-admin' : 'role-gm' }}">
                        {{ $gm->isAdministrator() ? 'Administrator' : 'Game Master' }}
                    </span>
                    <div class="member-info">
                        Member since {{ $gm->created_at->format('M Y') }}
                    </div>
                    @php
                        $gmCharacters = $gm->roles();
                    @endphp
                    @if(count($gmCharacters) > 0)
                        <div style="margin: 10px 0;">
                            <button onclick="toggleCharacters('gm-chars-{{ $gm->ID }}')" style="background: rgba(147, 112, 219, 0.2); border: 1px solid rgba(147, 112, 219, 0.4); border-radius: 10px; padding: 8px 15px; color: #e6d7f0; cursor: pointer; font-size: 0.9rem; font-weight: 600; font-family: Arial, sans-serif;">
                                {{ count($gmCharacters) }} Characters ▼
                            </button>
                            <div id="gm-chars-{{ $gm->ID }}" style="display: none; margin-top: 10px; background: rgba(26, 15, 46, 0.8); border-radius: 10px; padding: 10px; text-align: left;">
                                @foreach($gmCharacters as $character)
                                    @php
                                        $isOnline = isset($onlineCharacters[$character['id']]);
                                    @endphp
                                    <div style="padding: 5px 0; color: {{ $isOnline ? '#10b981' : '#b19cd9' }}; font-size: 0.9rem; font-weight: 500; font-family: Arial, sans-serif; text-transform: none;">
                                        @if($isOnline)
                                            <span style="color: #10b981; margin-right: 5px;">●</span>
                                        @endif
                                        {{ $character['name'] ?? 'Unknown' }}
                                        @if($isOnline)
                                            <span style="color: #10b981; font-size: 0.8rem; margin-left: 5px;">(Online)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($gm->discord_id)
                        <div class="discord-info">
                            <svg class="discord-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                            </svg>
                            {{ $gm->discord_id }}
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="members-section">
            <h2 class="section-title">Registered Players ({{ $totalMembers ?? count($members) }})</h2>
            
            <!-- Search Box -->
            <div style="text-align: center; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                <form method="GET" action="{{ route('public.members') }}" style="display: inline-block;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="Search by username..." 
                               style="background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.3); border-radius: 10px; padding: 10px 15px; color: #e6d7f0; font-size: 1rem; width: 300px;">
                        <button type="submit" style="background: linear-gradient(45deg, #9370db, #8a2be2); border: none; border-radius: 10px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer;">
                            Search
                        </button>
                        @if($search)
                            <a href="{{ route('public.members') }}" style="color: #b19cd9; text-decoration: none; padding: 10px;">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
            
            <div class="members-list">
                @if(count($members) > 0)
                    <table class="members-table">
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Characters</th>
                                <th>Member Since</th>
                                <th>Discord</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>
                                    <img src="{{ $member->profile_photo_url }}" alt="{{ $member->truename ?? $member->name }}" class="member-list-avatar">
                                    <span class="member-list-name">{{ $member->truename ?? $member->name }}</span>
                                </td>
                                <td>
                                    @php
                                        $characters = $member->roles();
                                    @endphp
                                    @if(count($characters) > 0)
                                        <div class="character-dropdown">
                                            <button onclick="toggleCharacters('chars-{{ $member->ID }}')" style="background: rgba(147, 112, 219, 0.2); border: 1px solid rgba(147, 112, 219, 0.4); border-radius: 5px; padding: 5px 10px; color: #e6d7f0; cursor: pointer; font-size: 0.85rem; font-family: Arial, sans-serif;">
                                                {{ count($characters) }} Characters ▼
                                            </button>
                                            <div id="chars-{{ $member->ID }}" style="display: none; margin-top: 10px; background: rgba(26, 15, 46, 0.6); border-radius: 5px; padding: 10px;">
                                                @foreach($characters as $character)
                                                    @php
                                                        $isOnline = isset($onlineCharacters[$character['id']]);
                                                    @endphp
                                                    <div style="padding: 3px 0; color: {{ $isOnline ? '#10b981' : '#b19cd9' }}; font-size: 0.85rem; font-family: Arial, sans-serif; text-transform: none;">
                                                        @if($isOnline)
                                                            <span style="color: #10b981; margin-right: 5px;">●</span>
                                                        @endif
                                                        {{ $character['name'] ?? 'Unknown' }}
                                                        @if($isOnline)
                                                            <span style="color: #10b981; font-size: 0.75rem; margin-left: 5px;">(Online)</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <span style="color: #666; font-size: 0.85rem;">No characters</span>
                                    @endif
                                </td>
                                <td>{{ $member->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($member->discord_id)
                                        <div class="discord-list-info">
                                            <svg class="discord-icon" style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                                            </svg>
                                            {{ $member->discord_id }}
                                        </div>
                                    @else
                                        <span class="no-discord-list">Not shared</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; color: #b19cd9; padding: 40px;">
                        No registered players yet. Be the first to join!
                    </div>
                @endif
                
                @if(isset($totalPages) && $totalPages > 1)
                    <div style="text-align: center; margin-top: 30px;">
                        @if($page > 1)
                            <a href="?page={{ $page - 1 }}" style="color: #9370db; text-decoration: none; margin: 0 10px;">← Previous</a>
                        @endif
                        
                        <span style="color: #b19cd9; margin: 0 15px;">Page {{ $page }} of {{ $totalPages }}</span>
                        
                        @if($page < $totalPages)
                            <a href="?page={{ $page + 1 }}" style="color: #9370db; text-decoration: none; margin: 0 10px;">Next →</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @php
            $footerSettings = \App\Models\FooterSetting::first();
            $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Begin your journey through the realms of endless cultivation</p>';
            $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
            $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
        @endphp
        <div class="footer footer-{{ $footerAlignment }}">
            {!! $footerContent !!}
            <p class="footer-text">{!! $footerCopyright !!}</p>
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

        // Initialize particles
        createParticles();
        
        // Toggle character dropdown
        function toggleCharacters(id) {
            const element = document.getElementById(id);
            if (element.style.display === 'none' || element.style.display === '') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }
        
        // Login box collapse functionality
        function toggleLoginBox() {
            const loginBox = document.getElementById('loginBox');
            loginBox.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = loginBox.classList.contains('collapsed');
            localStorage.setItem('loginBoxCollapsed', isCollapsed);
        }

        // Restore login box state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const loginBox = document.getElementById('loginBox');
            const savedState = localStorage.getItem('loginBoxCollapsed');
            
            // If user has never interacted with it, keep it collapsed (default)
            // If user has explicitly expanded it, respect their choice
            if (savedState === 'false') {
                loginBox.classList.remove('collapsed');
            }
            // Otherwise it stays collapsed (default state or explicitly collapsed)
        });

        // Handle dropdown clicks
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
        
        // Simple PIN check
        const usernameInput = document.querySelector('input[name="name"]');
        const pinField = document.getElementById('pin-field');
        
        if (usernameInput) {
            usernameInput.addEventListener('blur', function() {
                if (this.value.length > 2) {
                    // For simplicity, show PIN field for all users
                    // In production, you'd check via API
                    pinField.style.display = 'block';
                }
            });
        }
    </script>
    @livewireScripts
</body>
</html>