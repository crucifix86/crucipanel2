<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World</title>
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
        
        .container-inner {
            position: relative;
        }

        .header {
            margin-bottom: 60px;
            padding: 60px 0;
            position: relative;
        }
        
        .header-left {
            text-align: left;
            padding-left: 40px;
            padding-right: 40px;
        }
        
        .header-center {
            text-align: center;
        }
        
        .header-right {
            text-align: right;
            padding-left: 40px;
            padding-right: 40px;
        }
        
        .header a {
            display: block;
            position: relative;
            z-index: 10;
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

        /* Login Box Container */
        .login-box-wrapper {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
            width: 280px;
        }
        
        /* Login Box */
        .login-box {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 0;
            min-width: 280px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }
        
        .login-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(147, 112, 219, 0.3);
            cursor: pointer;
        }
        
        .login-box-header h3 {
            margin: 0;
            color: #9370db;
            font-size: 1.2rem;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }
        
        .collapse-toggle {
            background: none;
            border: none;
            color: #b19cd9;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 5px;
        }
        
        .collapse-toggle:hover {
            color: #9370db;
        }
        
        .login-box.collapsed .collapse-toggle {
            transform: rotate(180deg);
        }
        
        .login-box-content {
            padding: 25px;
            max-height: 500px;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        
        .login-box.collapsed .login-box-content {
            max-height: 0;
            padding: 0 25px;
        }

        .login-box-content h3 {
            color: #9370db;
            font-size: 1.4rem;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        .login-form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(147, 112, 219, 0.5);
            border-radius: 10px;
            color: #e6d7f0;
            font-size: 1rem;
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
            padding: 12px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .login-links {
            text-align: center;
            margin-top: 15px;
        }

        .login-links a {
            color: #b19cd9;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 0 10px;
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
            font-size: 1.3rem;
            color: #9370db;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .user-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .user-link {
            background: rgba(147, 112, 219, 0.2);
            border: 1px solid rgba(147, 112, 219, 0.4);
            color: #e6d7f0;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .user-link:hover {
            background: rgba(147, 112, 219, 0.3);
            border-color: #9370db;
            transform: translateY(-2px);
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

    <style>
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

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
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
            display: inline-block;
        }

        .nav-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.3));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 15px 0;
            min-width: 200px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .nav-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .dropdown-item {
            display: block;
            padding: 12px 25px;
            color: #b19cd9;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .dropdown-item:hover {
            background: rgba(147, 112, 219, 0.2);
            color: #fff;
            padding-left: 30px;
        }

        /* Account Section */
        .account-section {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
        }

        .account-button {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .account-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        /* Main Content Section */
        .content-section {
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

        .content-section::before {
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
            margin-bottom: 40px;
            color: #9370db;
            text-align: center;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
            position: relative;
            z-index: 1;
        }

        /* News Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .news-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .news-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .news-card:hover::before {
            left: 100%;
        }

        .news-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: #9370db;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.4),
                0 0 50px rgba(147, 112, 219, 0.3);
        }

        .news-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
            text-align: center;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .news-title {
            font-size: 1.6rem;
            color: #9370db;
            margin-bottom: 15px;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
            font-weight: 600;
        }

        .news-title a {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .news-title a:hover {
            color: #dda0dd;
        }

        .news-meta {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .news-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .news-category {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .news-description {
            color: #b19cd9;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .read-more-btn {
            background: linear-gradient(45deg, #9370db, #8a2be2, #4b0082);
            background-size: 300% 300%;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-block;
            animation: buttonGlow 2s ease-in-out infinite alternate;
        }

        @keyframes buttonGlow {
            0% { 
                box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
                background-position: 0% 50%;
            }
            100% { 
                box-shadow: 0 8px 30px rgba(138, 43, 226, 0.6);
                background-position: 100% 50%;
            }
        }

        .read-more-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(147, 112, 219, 0.8);
        }

        /* Server Features */
        .server-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #9370db, #8a2be2, #4b0082);
            animation: progressBar 3s ease-in-out infinite;
        }

        @keyframes progressBar {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #9370db;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #b19cd9;
        }

        .feature-value {
            font-size: 1.1rem;
            color: #8a2be2;
            font-weight: 600;
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

        .chinese-blessing {
            font-size: 1.3rem;
            color: #9370db;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 3rem;
            }
            
            .login-box-wrapper {
                position: relative;
                top: auto;
                right: auto;
                margin: 20px auto;
                max-width: 90%;
            }
            
            .content-section {
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
            
            .account-section {
                position: static;
                margin-top: 15px;
                transform: none;
            }
        }

        .epic-glow {
            animation: epicGlow 3s ease-in-out infinite alternate;
        }

        @keyframes epicGlow {
            0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
            100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
        }

    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
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
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
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
                
                @isset($download)
                    @if( $download->exists() && $download->count() > 0 )
                        <a href="{{ route('show.article', $download->first()->slug ) }}" class="nav-link">Download</a>
                    @endif
                @endisset
                
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
            </div>
            
        </nav>

        <div class="content-section">
            <h2 class="section-title">Latest News & Updates</h2>
            <div class="news-grid">
                @if( isset($news) && $news->items() )
                    @foreach( $news as $article )
                        <div class="news-card">
                            <span class="news-icon">
                                @if($article->category == 'update')
                                    ✨
                                @elseif($article->category == 'event')
                                    🎆
                                @elseif($article->category == 'maintenance')
                                    🔧
                                @else
                                    📜
                                @endif
                            </span>
                            <h3 class="news-title"><a href="{{ route('show.article', $article->slug) }}">{{ $article->title }}</a></h3>
                            <div class="news-meta">
                                <span class="news-date">📅 {{ $article->date( $article->created_at ) }}</span>
                                <span class="news-category">{{ __('news.category.' . $article->category) }}</span>
                            </div>
                            <p class="news-description">{{ Str::limit($article->description, 150) }}</p>
                            <a href="{{ route('show.article', $article->slug ) }}" class="read-more-btn">Read More</a>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; color: #b19cd9;">
                        <p>📜 No news articles at the moment</p>
                        <p>Check back soon for updates!</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="server-features">
            <div class="feature-card">
                <div class="feature-icon">🌟</div>
                <div class="feature-title">EXP Rate</div>
                <div class="feature-value">5x Experience · 3x Spirit</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚖️</div>
                <div class="feature-title">Max Level</div>
                <div class="feature-value">Level 105 · Rebirth x2</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏛️</div>
                <div class="feature-title">Server Version</div>
                <div class="feature-value">Perfect World v1.4.6</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚔️</div>
                <div class="feature-title">PvP Mode</div>
                <div class="feature-value">Balanced PK · Territory Wars</div>
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

        // Handle dropdown clicks
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });

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
    </script>
</body>
</html>
