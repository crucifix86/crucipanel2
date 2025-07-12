<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World - Donate</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 60px;
            padding: 60px 0;
            position: relative;
        }

        .logo-container {
            position: relative;
            display: inline-block;
        }

        .logo {
            font-size: 4.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 50px rgba(147, 112, 219, 0.8);
            letter-spacing: 3px;
            margin-bottom: 15px;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .tagline {
            font-size: 1.4rem;
            color: #b19cd9;
            margin-bottom: 30px;
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

        /* Navigation Bar */
        .nav-bar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 15px 30px;
            margin-bottom: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 10;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-link {
            color: #b19cd9;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1.1rem;
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

        /* Donate Section */
        .donate-section {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 30px;
            padding: 50px;
            margin-bottom: 50px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(147, 112, 219, 0.2);
            position: relative;
            overflow: hidden;
        }

        .donate-section::before {
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

        .section-title {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: #9370db;
            text-align: center;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
            position: relative;
            z-index: 1;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #b19cd9;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        /* Donation Methods Grid */
        .donation-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
        }

        .donation-method {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .donation-method::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .donation-method:hover::before {
            left: 100%;
        }

        .donation-method:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #9370db;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.4),
                0 0 50px rgba(147, 112, 219, 0.3);
        }

        .method-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            display: block;
        }

        .method-name {
            font-size: 1.6rem;
            color: #dda0dd;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .method-description {
            font-size: 1rem;
            color: #b19cd9;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .method-status {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
        }

        .method-status.disabled {
            background: linear-gradient(45deg, #6c757d, #495057);
        }

        .donate-button {
            display: inline-block;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .donate-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .payment-details {
            margin: 20px 0;
            padding: 15px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: #b19cd9;
            font-weight: 600;
        }

        .detail-value {
            color: #e6d7f0;
            font-weight: 500;
        }

        .detail-item.bonus .detail-value {
            color: #ffd700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
        }

        .bank-accounts {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(147, 112, 219, 0.3);
        }

        .bank-title {
            color: #9370db;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .bank-info {
            background: rgba(147, 112, 219, 0.1);
            padding: 8px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            color: #dda0dd;
            font-size: 0.95rem;
        }

        /* Benefits Section */
        .benefits-section {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            position: relative;
            z-index: 1;
        }

        .benefits-title {
            font-size: 2rem;
            color: #9370db;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .benefits-list {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .benefit-item {
            text-align: center;
        }

        .benefit-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: block;
        }

        .benefit-text {
            color: #b19cd9;
            font-size: 1.1rem;
        }

        .login-notice {
            text-align: center;
            color: #b19cd9;
            font-size: 1.1rem;
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }

        .login-notice a {
            color: #9370db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-notice a:hover {
            color: #dda0dd;
            text-decoration: underline;
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

        /* Footer */
        .footer {
            padding: 40px 0;
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            margin-top: 60px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-radius: 20px;
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

        @media (max-width: 768px) {
            .logo {
                font-size: 3rem;
            }
            
            .server-status {
                position: fixed;
                top: 10px;
                left: 10px;
                right: 10px;
                width: auto;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .status-text {
                font-size: 1rem;
            }
            
            .players-online {
                font-size: 0.85rem;
            }
            
            .login-box-wrapper {
                position: fixed;
                top: 90px;
                left: 10px;
                right: 10px;
                width: auto;
                max-width: 300px;
            }
            
            .login-box {
                width: 100%;
            }
            
            .donate-section {
                padding: 30px 20px;
            }
            
            .nav-bar {
                padding: 15px 20px;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .nav-link {
                font-size: 1rem;
                padding: 8px 15px;
            }
        }

        .epic-glow {
            animation: epicGlow 3s ease-in-out infinite alternate;
        }

        @keyframes epicGlow {
            0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
            100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
        }

        /* Server Status */
        .server-status {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
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
        
        /* Login Box */
        .login-box-wrapper {
            position: fixed;
            top: 100px;
            left: 20px;
            z-index: 100;
            width: 220px;
        }
        
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
    </style>
    @livewireStyles
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Server Status -->
    @php
        $api = new \hrace009\PerfectWorldAPI\API();
        $point = new \App\Models\Point();
        $onlinePlayer = $point->getOnlinePlayer();
        $onlineCount = $api->online ? ($onlinePlayer >= 100 ? $onlinePlayer + config('pw-config.fakeonline', 0) : $onlinePlayer) : 0;
    @endphp
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
    
    <div class="container">
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
            <div class="nav-container">
                <div class="nav-links">
                    <a href="{{ route('HOME') }}" class="nav-link {{ request()->routeIs('HOME') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('public.shop') }}" class="nav-link {{ request()->routeIs('public.shop') ? 'active' : '' }}">Shop</a>
                    <a href="{{ route('public.donate') }}" class="nav-link {{ request()->routeIs('public.donate') ? 'active' : '' }}">Donate</a>
                    <a href="{{ route('public.rankings') }}" class="nav-link {{ request()->routeIs('public.rankings') ? 'active' : '' }}">Rankings</a>
                    <a href="{{ route('public.vote') }}" class="nav-link {{ request()->routeIs('public.vote') ? 'active' : '' }}">Vote</a>
                    
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
                    
                    <a href="{{ route('public.members') }}" class="nav-link {{ request()->routeIs('public.members') ? 'active' : '' }}">Members</a>
                </div>
                
                <div class="user-section">
                    @auth
                        <x-hrace009::user-avatar/>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="donate-section">
            <h2 class="section-title">Support Haven Perfect World</h2>
            <p class="section-subtitle">Your donations help keep the server running and improve the gaming experience for everyone</p>
            
            <div class="donation-methods">
                @if($paypalConfig['enabled'])
                <div class="donation-method">
                    <span class="method-icon">💳</span>
                    <h3 class="method-name">PayPal</h3>
                    <p class="method-description">Fast and secure payment processing with instant {{ $currency }} delivery</p>
                    <div class="payment-details">
                        <div class="detail-item">
                            <span class="detail-label">Rate:</span>
                            <span class="detail-value">{{ $paypalConfig['currency'] }} {{ number_format($paypalConfig['rate'], 2) }} = 1 {{ $currency }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Minimum:</span>
                            <span class="detail-value">{{ $paypalConfig['currency'] }} {{ number_format($paypalConfig['minimum'], 2) }}</span>
                        </div>
                        @if($paypalConfig['double'])
                        <div class="detail-item bonus">
                            <span class="detail-label">🎉 Bonus:</span>
                            <span class="detail-value">Double {{ $currency }} Active!</span>
                        </div>
                        @endif
                    </div>
                    @auth
                        <a href="{{ route('app.donate.paypal') }}" class="donate-button">Donate via PayPal</a>
                    @else
                        <span class="method-status">Login Required</span>
                    @endauth
                </div>
                @endif
                
                @if($bankConfig['enabled'])
                <div class="donation-method">
                    <span class="method-icon">🏦</span>
                    <h3 class="method-name">Bank Transfer</h3>
                    <p class="method-description">Direct bank transfer with manual verification (1-2 business days)</p>
                    <div class="payment-details">
                        <div class="detail-item">
                            <span class="detail-label">Rate:</span>
                            <span class="detail-value">{{ $bankConfig['currency'] ?? 'IDR' }} {{ number_format($bankConfig['rate'], 0) }} = 1 {{ $currency }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Minimum:</span>
                            <span class="detail-value">{{ $bankConfig['minimum'] }} {{ $currency }}</span>
                        </div>
                        @if($bankConfig['double'])
                        <div class="detail-item bonus">
                            <span class="detail-label">🎉 Bonus:</span>
                            <span class="detail-value">Double {{ $currency }} Active!</span>
                        </div>
                        @endif
                        @if(count($bankConfig['banks']) > 0)
                        <div class="bank-accounts">
                            <p class="bank-title">Available Banks:</p>
                            @foreach($bankConfig['banks'] as $bank)
                                <div class="bank-info">{{ $bank['name'] }}</div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @auth
                        <a href="{{ route('app.donate.bank') }}" class="donate-button">Donate via Bank</a>
                    @else
                        <span class="method-status">Login Required</span>
                    @endauth
                </div>
                @endif
                
                @if($paymentwallEnabled)
                <div class="donation-method">
                    <span class="method-icon">🌐</span>
                    <h3 class="method-name">Paymentwall</h3>
                    <p class="method-description">Multiple payment options including mobile and prepaid cards</p>
                    @auth
                        <a href="{{ route('app.donate.paymentwall') }}" class="donate-button">Donate via Paymentwall</a>
                    @else
                        <span class="method-status">Login Required</span>
                    @endauth
                </div>
                @endif
                
                @if($ipaymuEnabled)
                <div class="donation-method">
                    <span class="method-icon">📱</span>
                    <h3 class="method-name">iPaymu</h3>
                    <p class="method-description">Indonesian payment gateway with local bank support</p>
                    @auth
                        <a href="{{ route('app.donate.ipaymu') }}" class="donate-button">Donate via iPaymu</a>
                    @else
                        <span class="method-status">Login Required</span>
                    @endauth
                </div>
                @endif
                
                @if(!$paypalConfig['enabled'] && !$bankConfig['enabled'] && !$paymentwallEnabled && !$ipaymuEnabled)
                <div style="text-align: center; padding: 60px 20px;">
                    <span style="font-size: 4rem; display: block; margin-bottom: 20px;">💳</span>
                    <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">No Payment Methods Configured</p>
                    <p style="color: #b19cd9;">Please contact an administrator to enable donation methods.</p>
                </div>
                @endif
            </div>
            
            <div class="benefits-section">
                <h3 class="benefits-title">Donation Benefits</h3>
                <div class="benefits-list">
                    <div class="benefit-item">
                        <span class="benefit-icon">💎</span>
                        <p class="benefit-text">{{ $currency }} Points</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">🎁</span>
                        <p class="benefit-text">Bonus Rewards</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">⚡</span>
                        <p class="benefit-text">Instant Delivery</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">🛡️</span>
                        <p class="benefit-text">Secure Payment</p>
                    </div>
                </div>
            </div>
            
            @guest
            <div class="login-notice">
                <p>Please <a href="{{ route('login') }}">login</a> to make a donation</p>
            </div>
            @else
            <div class="login-notice" style="color: #9370db;">
                <p>Welcome {{ Auth::user()->truename ?? Auth::user()->name }}! Thank you for supporting our realm.</p>
            </div>
            @endguest
        </div>

        @php
            $footerSettings = \App\Models\FooterSetting::first();
            $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Thank you for supporting our community</p>';
            $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
            $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
        @endphp
        <div class="footer footer-{{ $footerAlignment }}">
            {!! $footerContent !!}
            <p class="footer-text">{!! $footerCopyright !!}</p>
        </div>
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
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 6 + 6) + 's';
                
                // Random purple colors for particles
                const colors = ['#9370db', '#8a2be2', '#4b0082', '#6a5acd'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();

        // Close dropdown when clicking outside
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

        // Add page entrance animation
        window.addEventListener('load', function() {
            document.querySelector('.container').style.animation = 'fadeInUp 1.5s ease-out';
            const fadeInUpStyle = document.createElement('style');
            fadeInUpStyle.textContent = `
                @keyframes fadeInUp {
                    0% {
                        opacity: 0;
                        transform: translateY(50px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(fadeInUpStyle);
        });
    </script>
    @livewireScripts
</body>
</html>