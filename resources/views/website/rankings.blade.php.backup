@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.rankings.title'))

@section('styles')
@parent
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
            transform: none !important;
            will-change: auto !important;
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
            max-width: 1000px;
            margin-left: 260px;
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

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #b19cd9;
            text-decoration: none;
            padding: 8px 15px;
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

        /* Content Section (for PvP) */
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

        /* Rankings Section */
        .rankings-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .ranking-section {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(147, 112, 219, 0.2);
            position: relative;
            overflow: hidden;
        }

        .ranking-section::before {
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
            font-size: 2.2rem;
            margin-bottom: 30px;
            color: #9370db;
            text-align: center;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
            position: relative;
            z-index: 1;
        }

        .ranking-table {
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .ranking-row {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .ranking-row:hover {
            transform: translateX(10px);
            background: rgba(147, 112, 219, 0.2);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.3);
        }

        .rank-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #9370db;
            width: 50px;
            text-align: center;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
        }

        .rank-1 { color: #ffd700; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8); }
        .rank-2 { color: #c0c0c0; text-shadow: 0 0 20px rgba(192, 192, 192, 0.8); }
        .rank-3 { color: #cd7f32; text-shadow: 0 0 20px rgba(205, 127, 50, 0.8); }

        .player-info {
            flex: 1;
            margin-left: 20px;
        }

        .player-name {
            font-size: 1.2rem;
            color: #dda0dd;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .player-details {
            font-size: 0.9rem;
            color: #b19cd9;
        }

        .player-level {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            min-width: 80px;
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
        
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-content-section {
            flex: 1;
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

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .social-link {
            color: #b19cd9;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(147, 112, 219, 0.1);
            border: 1px solid rgba(147, 112, 219, 0.3);
        }

        .social-link:hover {
            color: #fff;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.5);
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
                transform: none;
            }
            
            .status-text {
                font-size: 1rem;
            }
            
            .footer-container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .footer-content-section {
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
                flex-wrap: wrap;
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
                transform: none;
            }
            
            .login-box {
                width: 100%;
            }
            
            .rankings-container {
                grid-template-columns: 1fr;
            }
            
            .ranking-section {
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
            z-index: 9999;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 10px 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 220px;
            transform: none;
            will-change: auto;
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
            z-index: 9998;
            width: 220px;
            transform: none;
            will-change: auto;
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
@endsection

@section('content')
<div class="content-section">
    <div class="rankings-container">
            <!-- Top Players Section -->
            <div class="ranking-section">
                <h2 class="section-title">{{ __('site.rankings.top_players') }}</h2>
                <!-- Debug: {{ $topPlayers->count() }} players found -->
                <div class="ranking-table">
                    @if($topPlayers->count() == 0)
                        <div style="text-align: center; padding: 40px; color: #b19cd9;">
                            {{ __('site.rankings.no_players') }}
                        </div>
                    @endif
                    @foreach($topPlayers as $index => $player)
                        <div class="ranking-row">
                            <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                                {{ $index + 1 }}
                            </div>
                            <div class="player-info">
                                <div class="player-name">{{ $player->name }}</div>
                                <div class="player-details">
                                    @php
                                        $classKey = 'site.rankings.classes.' . $player->cls;
                                        $className = __($classKey) !== $classKey ? __($classKey) : __('site.rankings.classes.unknown');
                                    @endphp
                                    {{ $className }}
                                </div>
                            </div>
                            <div class="player-level">
                                {{ __('site.rankings.level') }} {{ $player->level }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Factions Section -->
            <div class="ranking-section">
                <h2 class="section-title">{{ __('site.rankings.top_factions') }}</h2>
                <div class="ranking-table">
                    @foreach($topFactions as $index => $faction)
                        <div class="ranking-row">
                            <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                                {{ $index + 1 }}
                            </div>
                            <div class="player-info">
                                <div class="player-name">{{ $faction->name }}</div>
                                <div class="player-details">
                                    {{ __('site.rankings.members') }} {{ $faction->members->count() }}
                                </div>
                            </div>
                            <div class="player-level">
                                {{ __('site.rankings.level') }} {{ $faction->level }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- PvP Rankings Section -->
        <div class="content-section" style="margin-top: 40px;">
            <h2 class="section-title" style="color: #ff6b6b; text-shadow: 0 0 30px rgba(255, 107, 107, 0.8);">{{ __('site.rankings.pvp_champions') }}</h2>
            <div class="ranking-table">
                @foreach($topPvPPlayers as $index => $player)
                    <div class="ranking-row">
                        <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                            {{ $index + 1 }}
                        </div>
                        <div class="player-info">
                            <div class="player-name">{{ $player->name }}</div>
                            <div class="player-details">
                                @php
                                    $classKey = 'site.rankings.classes.' . $player->cls;
                                    $className = __($classKey) !== $classKey ? __($classKey) : __('site.rankings.classes.unknown');
                                @endphp
                                {{ $className }} - {{ __('site.rankings.level') }} {{ $player->level }}
                            </div>
                        </div>
                        <div class="player-level" style="background: linear-gradient(45deg, #ff6b6b, #dc3545); min-width: 100px;">
                            {{ $player->pk_count }} {{ __('site.rankings.kills') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>
@endsection

