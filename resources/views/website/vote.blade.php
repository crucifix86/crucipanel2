<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World - Vote</title>
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

        /* Vote Section */
        .vote-section {
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

        .vote-section::before {
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

        /* Vote Sites Grid */
        .vote-sites {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
        }

        .vote-site {
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

        .vote-site::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .vote-site:hover::before {
            left: 100%;
        }

        .vote-site:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #9370db;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.4),
                0 0 50px rgba(147, 112, 219, 0.3);
        }

        .site-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            display: block;
            color: #9370db;
        }

        .site-name {
            font-size: 1.6rem;
            color: #dda0dd;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .site-reward {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        }

        .site-cooldown {
            font-size: 1rem;
            color: #b19cd9;
            margin-bottom: 20px;
        }

        .vote-button {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .vote-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .method-status {
            background: linear-gradient(45deg, #6c757d, #495057);
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
        }

        .cooldown-timer {
            background: rgba(255, 107, 107, 0.2);
            border: 1px solid rgba(255, 107, 107, 0.4);
            border-radius: 20px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .cooldown-icon {
            font-size: 1.3rem;
        }

        .cooldown-text {
            color: #ff6b6b;
            font-weight: 600;
        }

        .time-remaining {
            font-family: monospace;
            font-size: 1.1rem;
        }

        /* Rewards Info */
        .rewards-info {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            position: relative;
            z-index: 1;
        }

        .rewards-title {
            font-size: 2rem;
            color: #9370db;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .rewards-list {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .reward-item {
            text-align: center;
        }

        .reward-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: block;
        }

        .reward-text {
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
            
            .server-status,
            .login-box-wrapper {
                display: none;
            }
            
            .vote-section {
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
        
        /* User Info Bar */
        .user-info-bar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            z-index: 10;
        }

        .user-balance {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .balance-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .balance-icon {
            font-size: 1.3rem;
        }

        .balance-label {
            color: #b19cd9;
            font-weight: 600;
        }

        .balance-value {
            color: #ffd700;
            font-size: 1.2rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
        }
        
        /* Arena Top 100 Styles */
        .arena-section {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 140, 0, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 215, 0, 0.4);
            border-radius: 25px;
            padding: 35px;
            box-shadow: 
                0 20px 60px rgba(255, 215, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .arena-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 215, 0, 0.1), transparent);
            animation: shimmerGold 4s ease-in-out infinite;
        }
        
        @keyframes shimmerGold {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .arena-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .arena-title {
            font-size: 2rem;
            color: #ffd700;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.8);
            margin: 0;
        }
        
        .arena-reward {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            padding: 10px 20px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
        }
        
        .reward-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4a0e4e;
            margin-right: 5px;
        }
        
        .reward-type {
            font-size: 1.1rem;
            color: #4a0e4e;
            font-weight: 600;
        }
        
        .arena-body {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .arena-description {
            color: #ffed4e;
            font-size: 1.1rem;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 237, 78, 0.5);
        }
        
        .arena-button {
            background: linear-gradient(45deg, #ffd700, #ffa500);
            color: #4a0e4e;
            font-weight: 700;
            font-size: 1.2rem;
            padding: 15px 40px;
        }
        
        .arena-button:hover {
            background: linear-gradient(45deg, #ffed4e, #ffd700);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.6);
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
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <!-- Server Status and Login Box must be outside any transformed containers -->
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
                <a href="{{ route('HOME') }}" class="nav-link">Home</a>
                
                @if( config('pw-config.system.apps.shop') )
                <a href="{{ route('public.shop') }}" class="nav-link">Shop</a>
                @endif
                
                @if( config('pw-config.system.apps.donate') )
                <a href="{{ route('public.donate') }}" class="nav-link">Donate</a>
                @endif
                
                @if( config('pw-config.system.apps.ranking') )
                <a href="{{ route('public.rankings') }}" class="nav-link">Rankings</a>
                @endif
                
                @if( config('pw-config.system.apps.vote') )
                <a href="{{ route('public.vote') }}" class="nav-link active">Vote</a>
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
            </div>
        </nav>

        <div class="vote-section">
            <h2 class="section-title">Vote for Haven Perfect World</h2>
            <p class="section-subtitle">Support our server and earn rewards by voting on these sites</p>
            
            @auth
            <!-- User Info Bar -->
            <div class="user-info-bar">
                <div class="user-balance">
                    <div class="balance-item">
                        <span class="balance-icon">💰</span>
                        <span class="balance-label">{{ config('pw-config.currency_name', 'Coins') }}:</span>
                        <span class="balance-value">{{ number_format(Auth::user()->money, 0, '', '.') }}</span>
                    </div>
                    <div class="balance-item">
                        <span class="balance-icon">⭐</span>
                        <span class="balance-label">Bonus Points:</span>
                        <span class="balance-value">{{ number_format(Auth::user()->bonuses, 0, '', '.') }}</span>
                    </div>
                </div>
                
                <div style="color: #b19cd9; font-style: italic;">
                    Vote to earn rewards and see your balance increase!
                </div>
            </div>
            @endauth
            
            <!-- Session Messages -->
            @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.2); border: 2px solid #10b981; padding: 15px 25px; border-radius: 15px; margin-bottom: 30px; text-align: center;">
                <span style="color: #10b981; font-size: 1.1rem;">✓ {{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.2); border: 2px solid #ef4444; padding: 15px 25px; border-radius: 15px; margin-bottom: 30px; text-align: center;">
                <span style="color: #ef4444; font-size: 1.1rem;">✗ {{ session('error') }}</span>
            </div>
            @endif
            
            <!-- Arena Vote Success Notification -->
            @if(isset($arena_vote_success) && $arena_vote_success)
            @php
                $arenaSuccess = $arena_vote_success;
            @endphp
            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(147, 112, 219, 0.2)); border: 2px solid #10b981; padding: 20px 30px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                <span style="font-size: 2rem; display: block; margin-bottom: 10px;">🎉</span>
                <span style="color: #10b981; font-size: 1.3rem; font-weight: 600; display: block; margin-bottom: 10px;">
                    Arena Top 100 Vote Confirmed!
                </span>
                <span style="color: #e6d7f0; font-size: 1.1rem;">
                    +{{ $arenaSuccess['reward_amount'] }} 
                    @if($arenaSuccess['reward_type'] == 'virtual')
                        {{ config('pw-config.currency_name', 'Coins') }}
                    @elseif($arenaSuccess['reward_type'] == 'cubi')
                        Gold
                    @else
                        Bonus Points
                    @endif
                    has been added to your account!
                </span>
                <script>
                    // Show immediate notification as well
                    showNotification('success', 'Arena Top 100 confirmed your vote! +{{ $arenaSuccess['reward_amount'] }} @if($arenaSuccess['reward_type'] == 'virtual'){{ config('pw-config.currency_name', 'Coins') }}@elseif($arenaSuccess['reward_type'] == 'cubi')Gold@else Bonus Points@endif added!');
                </script>
            </div>
            @endif
            
            <!-- Arena Top 100 Section -->
            @if(config('arena.status') === true && Auth::check())
            <div style="margin-bottom: 50px;">
                <div class="arena-section">
                    <div class="arena-header">
                        <h3 class="arena-title">
                            <span style="font-size: 2rem; margin-right: 10px;">🏆</span>
                            Arena Top 100
                        </h3>
                        <div class="arena-reward">
                            <span class="reward-amount">+{{ config('arena.reward') }}</span>
                            <span class="reward-type">
                                @if(config('arena.reward_type') === 'cubi')
                                    Gold
                                @elseif(config('arena.reward_type') === 'virtual')
                                    {{ config('pw-config.currency_name', 'Coins') }}
                                @else
                                    Bonus Points
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="arena-body">
                        <p class="arena-description">Vote every {{ config('arena.time') }} hours on Arena Top 100</p>
                        @if(isset($arena_info[Auth::user()->ID]) && $arena_info[Auth::user()->ID]['status'])
                            <form id="vote-form-arena" action="{{ route('app.vote.arena.submit') }}" method="POST" target="_blank" onsubmit="return handleVoteSubmit('Arena Top 100', 'arena', {{ config('arena.reward') }}, '{{ config('arena.reward_type') }}')">
                                @csrf
                                <button type="submit" class="vote-button arena-button">
                                    <span style="margin-right: 8px;">🗳️</span>
                                    Vote on Arena Top 100
                                </button>
                            </form>
                            <button class="vote-button check-vote-btn" id="check-vote-arena" style="background: linear-gradient(45deg, #28a745, #20c997); margin-top: 10px; display: none;" onclick="checkVoteStatus('arena')">
                                ✓ Claim Rewards
                            </button>
                        @else
                            <div class="cooldown-timer" data-time="{{ $arena_info[Auth::user()->ID]['end_time'] ?? 0 }}">
                                <span class="cooldown-icon">⏱️</span>
                                <span class="cooldown-text">Please wait: <span class="time-remaining">--:--:--</span></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div style="text-align: center; padding: 60px 20px; margin-top: 40px;">
                <span style="font-size: 4rem; display: block; margin-bottom: 20px;">🗳️</span>
                <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">Arena Top 100 Only</p>
                <p style="color: #b19cd9;">We use Arena Top 100's verified voting system to ensure fair rewards!</p>
            </div>
            @endif
            
            <div class="rewards-info">
                <h3 class="rewards-title">Why Vote?</h3>
                <div class="rewards-list">
                    <div class="reward-item">
                        <span class="reward-icon">💰</span>
                        <p class="reward-text">Earn Currency</p>
                    </div>
                    <div class="reward-item">
                        <span class="reward-icon">📈</span>
                        <p class="reward-text">Help Server Grow</p>
                    </div>
                    <div class="reward-item">
                        <span class="reward-icon">🎯</span>
                        <p class="reward-text">Daily Rewards</p>
                    </div>
                    <div class="reward-item">
                        <span class="reward-icon">🏆</span>
                        <p class="reward-text">Top Voter Prizes</p>
                    </div>
                </div>
            </div>
            
            @guest
            <div class="login-notice">
                <p>Please <a href="{{ route('login') }}">login</a> to vote and receive rewards</p>
            </div>
            @else
            <div class="login-notice" style="color: #9370db;">
                <p>Welcome {{ Auth::user()->truename ?? Auth::user()->name }}! Vote to support our server and earn rewards.</p>
            </div>
            @endguest
        </div>

        @php
            $footerSettings = \App\Models\FooterSetting::first();
            $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Every vote helps our community grow</p>';
            $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
            $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
        @endphp
        <div class="footer footer-{{ $footerAlignment }}">
            {!! $footerContent !!}
            <p class="footer-text">{!! $footerCopyright !!}</p>
        </div>
    </div>

    <script>
        // Countdown timer functionality
        function updateTimers() {
            const timers = document.querySelectorAll('.cooldown-timer');
            timers.forEach(timer => {
                const timeLeft = parseInt(timer.getAttribute('data-time'));
                const display = timer.querySelector('.time-remaining');
                
                if (timeLeft > 0) {
                    const hours = Math.floor(timeLeft / 3600);
                    const minutes = Math.floor((timeLeft % 3600) / 60);
                    const seconds = timeLeft % 60;
                    
                    display.textContent = 
                        String(hours).padStart(2, '0') + ':' +
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');
                    
                    timer.setAttribute('data-time', timeLeft - 1);
                } else {
                    // Reload page when timer expires
                    location.reload();
                }
            });
        }

        // Update timers every second
        setInterval(updateTimers, 1000);
        updateTimers(); // Initial update

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
        
        // Vote functions
        function handleVoteSubmit(siteName, siteId, rewardAmount, rewardType) {
            // For Arena Top 100
            if (siteId === 'arena') {
                showNotification('info', `Opening Arena Top 100 voting page. Complete your vote and your rewards will be automatically applied when Arena confirms your vote!`);
                return true;
            }
            
            // This shouldn't happen anymore but just in case
            showNotification('error', 'Only Arena Top 100 voting is supported.');
            return false;
        }
        
        function updateBalanceDisplay(newBalance) {
            // Update money display
            const moneyElements = document.querySelectorAll('.balance-value');
            if (moneyElements[0]) {
                moneyElements[0].textContent = new Intl.NumberFormat('en-US').format(newBalance.money);
                // Add flash effect
                moneyElements[0].style.animation = 'balanceFlash 1s ease-in-out';
            }
            
            // Update bonuses display
            if (moneyElements[1]) {
                moneyElements[1].textContent = new Intl.NumberFormat('en-US').format(newBalance.bonuses);
                // Add flash effect
                moneyElements[1].style.animation = 'balanceFlash 1s ease-in-out';
            }
        }
        
        function showNotification(type, message) {
            // Remove any existing notifications
            const existingNotif = document.querySelector('.vote-notification');
            if (existingNotif) {
                existingNotif.remove();
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'vote-notification';
            
            let bgColor, borderColor, textColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'rgba(16, 185, 129, 0.2)';
                    borderColor = '#10b981';
                    textColor = '#10b981';
                    icon = '✓';
                    break;
                case 'info':
                    bgColor = 'rgba(59, 130, 246, 0.2)';
                    borderColor = '#3b82f6';
                    textColor = '#3b82f6';
                    icon = 'ℹ️';
                    break;
                default:
                    bgColor = 'rgba(239, 68, 68, 0.2)';
                    borderColor = '#ef4444';
                    textColor = '#ef4444';
                    icon = '✗';
            }
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                border: 2px solid ${borderColor};
                padding: 20px 30px;
                border-radius: 15px;
                z-index: 10000;
                max-width: 400px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                animation: slideIn 0.3s ease-out;
            `;
            
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-size: 1.5rem;">${icon}</span>
                    <span style="color: ${textColor}; font-size: 1.1rem; font-weight: 600;">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove after 10 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 10000);
        }
        
        // Add animations
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            @keyframes balanceFlash {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); color: #ffd700; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8); }
            }
        `;
        document.head.appendChild(notificationStyle);
        
        // Check if vote was submitted when page regains focus
        window.addEventListener('focus', function() {
            if (sessionStorage.getItem('vote_submitted')) {
                sessionStorage.removeItem('vote_submitted');
                // Refresh page to show updated balance and cooldowns
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    </script>
</body>
</html>