<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World - Shop</title>
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

        /* Shop Section */
        .shop-section {
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

        .shop-section::before {
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

        /* Shop Grid */
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 1;
        }

        .shop-item {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .shop-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .shop-item:hover::before {
            left: 100%;
        }

        .shop-item:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #9370db;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.4),
                0 0 50px rgba(147, 112, 219, 0.3);
        }

        .item-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: rgba(147, 112, 219, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .item-name {
            font-size: 1.3rem;
            color: #dda0dd;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .item-description {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 20px;
            line-height: 1.4;
            min-height: 40px;
        }

        .item-price {
            font-size: 1.2rem;
            color: #ffd700;
            margin-bottom: 15px;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(45deg, #ff6b6b, #dc3545);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .purchase-button {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .purchase-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .bonus-button {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .bonus-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
        }

        /* Category Sidebar */
        .category-sidebar-link:hover {
            background: rgba(147, 112, 219, 0.3) !important;
            transform: translateX(5px);
            box-shadow: 0 3px 15px rgba(147, 112, 219, 0.4);
        }
        
        /* Custom scrollbar for category sidebar */
        .category-sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .category-sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(147, 112, 219, 0.1);
            border-radius: 3px;
        }
        
        .category-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(147, 112, 219, 0.4);
            border-radius: 3px;
        }
        
        .category-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(147, 112, 219, 0.6);
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

        .character-selector {
            position: relative;
            z-index: 999;
        }

        .selected-character, .no-character {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .char-icon {
            font-size: 1.3rem;
        }

        .char-label {
            color: #b19cd9;
            font-weight: 600;
        }

        .char-name {
            color: #dda0dd;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .change-char, .select-char {
            color: #9370db;
            text-decoration: none;
            padding: 5px 15px;
            border: 1px solid rgba(147, 112, 219, 0.5);
            border-radius: 15px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .change-char:hover, .select-char:hover {
            background: rgba(147, 112, 219, 0.2);
            border-color: #9370db;
            color: #dda0dd;
        }

        .warning {
            color: #ff6b6b;
            font-weight: 600;
        }

        .char-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.95), rgba(147, 112, 219, 0.3));
            backdrop-filter: blur(10px);
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 20px;
            min-width: 250px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .char-dropdown h4 {
            color: #9370db;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .char-option {
            display: block;
            padding: 10px 15px;
            margin-bottom: 8px;
            background: rgba(147, 112, 219, 0.1);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 10px;
            text-decoration: none;
            color: #e6d7f0;
            transition: all 0.3s ease;
        }

        .char-option:hover {
            background: rgba(147, 112, 219, 0.3);
            border-color: #9370db;
            transform: translateX(5px);
        }

        .char-option .char-name {
            font-weight: 600;
        }

        .no-chars {
            color: #b19cd9;
            text-align: center;
            padding: 20px;
        }

        .login-notice {
            text-align: center;
            color: #b19cd9;
            font-size: 1.1rem;
            margin-top: 20px;
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
                padding: 10px 15px;
                font-size: 0.9rem;
                width: auto;
                transform: none;
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
                transform: none;
            }
            
            .login-box {
                width: 100%;
            }
            
            .shop-section {
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
        
        /* Tab styles */
        .shop-tab {
            display: inline-block;
            padding: 12px 30px;
            background: rgba(147, 112, 219, 0.2);
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .shop-tab:hover {
            background: rgba(147, 112, 219, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }
        
        .shop-tab.active {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            box-shadow: 0 8px 30px rgba(147, 112, 219, 0.6);
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
    @livewireStyles
</head>
<body>
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
    
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
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

        <div class="shop-section">
            <h2 class="section-title">Mystical Shop</h2>
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div data-notification style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1)); border: 2px solid rgba(16, 185, 129, 0.4); border-radius: 15px; padding: 15px 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 5px 20px rgba(16, 185, 129, 0.3);">
                <p style="color: #10b981; font-size: 1.1rem; margin: 0; font-weight: 600;">
                    <span style="margin-right: 10px;">✓</span>{{ session('success') }}
                </p>
            </div>
            @endif
            
            @if(session('error'))
            <div data-notification style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.4); border-radius: 15px; padding: 15px 20px; margin-bottom: 30px; text-align: center; box-shadow: 0 5px 20px rgba(239, 68, 68, 0.3);">
                <p style="color: #ef4444; font-size: 1.1rem; margin: 0; font-weight: 600;">
                    <span style="margin-right: 10px;">✗</span>{{ session('error') }}
                </p>
            </div>
            @endif
            
            <!-- Search Bar -->
            <div style="text-align: center; margin-bottom: 30px;">
                <form method="GET" action="{{ route('public.shop') }}" style="display: inline-block;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="Search items, vouchers, or services..." 
                               style="background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.3); border-radius: 10px; padding: 10px 15px; color: #e6d7f0; font-size: 1rem; width: 400px;">
                        <button type="submit" style="background: linear-gradient(45deg, #9370db, #8a2be2); border: none; border-radius: 10px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer;">
                            Search
                        </button>
                        @if($search)
                            <a href="{{ route('public.shop') }}" style="color: #b19cd9; text-decoration: none; padding: 10px;">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Shop Tabs -->
            <div class="shop-tabs" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;">
                <a href="{{ route('public.shop', ['tab' => 'items']) }}" 
                   class="shop-tab {{ $tab === 'items' ? 'active' : '' }}">
                    <span style="margin-right: 8px;">📦</span> Items
                </a>
                <a href="{{ route('public.shop', ['tab' => 'vouchers']) }}" 
                   class="shop-tab {{ $tab === 'vouchers' ? 'active' : '' }}">
                    <span style="margin-right: 8px;">🎟️</span> Vouchers
                </a>
                <a href="{{ route('public.shop', ['tab' => 'services']) }}" 
                   class="shop-tab {{ $tab === 'services' ? 'active' : '' }}">
                    <span style="margin-right: 8px;">⚡</span> Services
                </a>
            </div>
            
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
                
                <div class="character-selector">
                    @if(Auth::user()->characterId())
                        <div class="selected-character">
                            <span class="char-icon">👤</span>
                            <span class="char-label">Character:</span>
                            <span class="char-name">{{ Auth::user()->characterName() }}</span>
                            <a href="#" class="change-char" onclick="toggleCharSelect(event)">Change</a>
                        </div>
                    @else
                        <div class="no-character">
                            <span class="char-icon">⚠️</span>
                            <span class="warning">No character selected</span>
                            <a href="#" class="select-char" onclick="toggleCharSelect(event)">Select Character</a>
                        </div>
                    @endif
                    
                    <!-- Character Selection Dropdown -->
                    <div class="char-dropdown" id="charDropdown" style="display: none;">
                        <h4>Select Character</h4>
                        @php
                            $api = new \hrace009\PerfectWorldAPI\API;
                        @endphp
                        
                        @if($api->online)
                            @php
                                $roles = Auth::user()->roles();
                            @endphp
                            
                            @if(count($roles) > 0)
                                @foreach($roles as $role)
                                    <a href="{{ url('character/select/' . $role['id']) }}" class="char-option">
                                        <span class="char-name">{{ $role['name'] }}</span>
                                    </a>
                                @endforeach
                            @else
                                <p class="no-chars">No characters found</p>
                            @endif
                        @else
                            <p class="no-chars">Server is offline</p>
                        @endif
                    </div>
                </div>
            </div>
            @endauth
            
            <!-- Items Layout with Sidebar -->
            @if($tab === 'items')
            <div style="display: flex; gap: 20px; margin-top: 20px;">
                <!-- Category Sidebar -->
                <div style="width: 250px; flex-shrink: 0;">
                    <div style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1)); border: 1px solid rgba(147, 112, 219, 0.3); border-radius: 15px; padding: 20px;">
                        <h3 style="color: #9370db; font-size: 1.2rem; margin-bottom: 15px; text-align: center; font-weight: 600;">Categories</h3>
                        <div class="category-sidebar-scroll" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
                            @foreach($categories as $category)
                                <a href="{{ route('public.shop', ['tab' => 'items', 'mask' => $category['mask']]) }}" 
                                   class="category-sidebar-link"
                                   style="display: flex; align-items: center; padding: 12px 15px; margin-bottom: 5px; background: {{ $currentMask == $category['mask'] && ($currentMask !== null || $category['mask'] === null) ? 'linear-gradient(45deg, #9370db, #8a2be2)' : 'rgba(147, 112, 219, 0.1)' }}; border-radius: 10px; text-decoration: none; color: {{ $currentMask == $category['mask'] && ($currentMask !== null || $category['mask'] === null) ? '#fff' : '#b19cd9' }}; transition: all 0.3s ease;">
                                    <span style="font-size: 1.2rem; margin-right: 10px;">{{ $category['icon'] }}</span>
                                    <span style="font-size: 0.95rem; font-weight: 500;">{{ $category['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Items Display Area -->
                <div style="flex-grow: 1;">
                    @if($items->count() > 0)
                    <div class="shop-grid">
                        @foreach($items as $item)
                    <div class="shop-item">
                        @if($item->discount > 0)
                            <div class="discount-badge">-{{ $item->discount }}%</div>
                        @endif
                        
                        <div class="item-icon">
                            @if($item->mask == 2)
                                👘
                            @elseif($item->mask == 4)
                                👗
                            @elseif($item->mask == 8)
                                🐴
                            @elseif($item->mask == 131072)
                                ⚔️
                            @else
                                📦
                            @endif
                        </div>
                        
                        <h3 class="item-name">{{ $item->name }}</h3>
                        <p class="item-description">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="item-price">
                            @if($item->discount > 0)
                                <div class="original-price" style="text-decoration: line-through; color: #b19cd9; font-size: 0.9rem;">
                                    {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                                </div>
                                {{ number_format($item->price * (1 - $item->discount/100)) }} {{ config('pw-config.currency_name', 'Points') }}
                            @else
                                {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.shop.purchase.post', $item->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    <button type="submit" class="purchase-button">Purchase</button>
                                </form>
                                
                                @if($item->poin > 0)
                                <form action="{{ route('app.shop.point.post', $item->id) }}" method="POST" style="margin-top: 10px;">
                                    @csrf
                                    <button type="submit" class="bonus-button">Buy with {{ $item->poin }} Bonus Points</button>
                                </form>
                                @endif
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">Select a character to purchase</p>
                            @endif
                        @endauth
                    </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination for items -->
                    @if($items->hasPages())
                    <div style="margin-top: 40px; text-align: center;">
                        <div style="display: inline-flex; gap: 10px; align-items: center;">
                            @if($items->onFirstPage())
                                <span style="padding: 8px 16px; color: #666; cursor: not-allowed;">← Previous</span>
                            @else
                                <a href="{{ $items->previousPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   style="padding: 8px 16px; background: rgba(147, 112, 219, 0.2); color: #dda0dd; text-decoration: none; border-radius: 8px; transition: all 0.3s;">
                                    ← Previous
                                </a>
                            @endif
                            
                            <span style="color: #b19cd9; padding: 0 10px;">
                                Page {{ $items->currentPage() }} of {{ $items->lastPage() }}
                            </span>
                            
                            @if($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}&tab=items{{ $currentMask !== null ? '&mask=' . $currentMask : '' }}" 
                                   style="padding: 8px 16px; background: rgba(147, 112, 219, 0.2); color: #dda0dd; text-decoration: none; border-radius: 8px; transition: all 0.3s;">
                                    Next →
                                </a>
                            @else
                                <span style="padding: 8px 16px; color: #666; cursor: not-allowed;">Next →</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div style="text-align: center; padding: 60px 20px;">
                        <span style="font-size: 4rem; display: block; margin-bottom: 20px;">📦</span>
                        <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">No Items Available</p>
                        <p style="color: #b19cd9;">Check back later for mystical items!</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Display Vouchers -->
            @if($tab === 'vouchers')
            <div style="text-align: center; padding: 40px 20px;">
                <div style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1)); border: 2px solid rgba(147, 112, 219, 0.3); border-radius: 20px; padding: 30px; display: inline-block; max-width: 500px;">
                    <h3 style="color: #9370db; font-size: 1.5rem; margin-bottom: 20px; text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);">
                        <span style="margin-right: 10px;">🎟️</span>Redeem Voucher Code
                    </h3>
                    
                    @auth
                        <form action="{{ route('app.voucher.postRedem') }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 20px;">
                                <input type="text" 
                                       name="code" 
                                       placeholder="Enter voucher code" 
                                       style="background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.5); border-radius: 10px; padding: 12px 20px; color: #e6d7f0; font-size: 1rem; width: 100%; font-family: Arial, sans-serif;"
                                       required>
                            </div>
                            <button type="submit" style="background: linear-gradient(45deg, #9370db, #8a2be2); border: none; border-radius: 20px; padding: 12px 40px; color: white; font-weight: 600; cursor: pointer; font-size: 1.1rem; transition: all 0.3s ease;">
                                Redeem Code
                            </button>
                        </form>
                        
                        <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 20px;">
                            Enter your voucher code above to add {{ config('pw-config.currency_name', 'Coins') }} to your account
                        </p>
                        
                        @if($voucherLogs->count() > 0)
                        <button onclick="toggleVoucherHistory()" style="background: rgba(147, 112, 219, 0.2); border: 1px solid rgba(147, 112, 219, 0.4); border-radius: 15px; padding: 8px 20px; color: #b19cd9; font-weight: 500; cursor: pointer; font-size: 0.9rem; margin-top: 15px; transition: all 0.3s ease;">
                            <span style="margin-right: 5px;">📋</span> View Redemption History
                        </button>
                        @endif
                    @else
                        <p style="color: #b19cd9; font-size: 1rem;">Please <a href="{{ route('login') }}" style="color: #9370db; text-decoration: underline;">login</a> to redeem voucher codes</p>
                    @endauth
                </div>
            </div>
            
            <!-- Voucher History Popup -->
            @auth
            @if($voucherLogs->count() > 0)
            <div id="voucherHistoryPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 10000; overflow-y: auto;">
                <div style="position: relative; max-width: 800px; margin: 50px auto; background: linear-gradient(135deg, #1a0f2e, #2a1b3d); border: 2px solid rgba(147, 112, 219, 0.4); border-radius: 20px; padding: 30px; box-shadow: 0 20px 60px rgba(147, 112, 219, 0.6);">
                    <button onclick="toggleVoucherHistory()" style="position: absolute; top: 15px; right: 15px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 50%; width: 40px; height: 40px; color: #ef4444; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease;">
                        ×
                    </button>
                    
                    <h2 style="color: #9370db; font-size: 1.8rem; margin-bottom: 25px; text-align: center; text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);">
                        <span style="margin-right: 10px;">📋</span>Voucher Redemption History
                    </h2>
                    
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid rgba(147, 112, 219, 0.4);">
                                    <th style="padding: 12px; text-align: left; color: #9370db; font-weight: 600;">Voucher Code</th>
                                    <th style="padding: 12px; text-align: center; color: #9370db; font-weight: 600;">Amount</th>
                                    <th style="padding: 12px; text-align: right; color: #9370db; font-weight: 600;">Redeemed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($voucherLogs as $log)
                                <tr style="border-bottom: 1px solid rgba(147, 112, 219, 0.2);">
                                    <td style="padding: 12px; color: #e6d7f0;">{{ $log->voucher->code ?? 'N/A' }}</td>
                                    <td style="padding: 12px; text-align: center; color: #10b981; font-weight: 600;">
                                        +{{ number_format($log->voucher->amount ?? 0) }} {{ config('pw-config.currency_name', 'Coins') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #b19cd9;">
                                        {{ $log->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <p style="text-align: center; color: #b19cd9; font-size: 0.9rem; margin-top: 20px;">
                        Total Vouchers Redeemed: {{ $voucherLogs->count() }}
                    </p>
                </div>
            </div>
            @endif
            @endauth
            @endif
            
            <!-- Display Services -->
            @if($tab === 'services' && $services->count() > 0)
            <div class="shop-grid">
                @foreach($services as $service)
                    @php
                        $info = $serviceInfo[$service->key] ?? ['name' => ucfirst(str_replace('_', ' ', $service->key)), 'icon' => '⚡', 'description' => ''];
                    @endphp
                    <div class="shop-item">
                        <div class="item-icon" style="font-size: 3rem;">{{ $info['icon'] }}</div>
                        <h3 class="item-name">{{ __('service.ingame.' . $service->key . '.title') }}</h3>
                        <p class="item-description">{{ __('service.ingame.' . $service->key . '.description') }}</p>
                        
                        <!-- Requirements -->
                        <div style="margin-top: 10px; margin-bottom: 15px; font-size: 0.85rem; color: #b19cd9;">
                            <strong>{{ __('service.requirements') }}</strong>
                            <ul style="list-style: disc; margin-left: 20px; margin-top: 5px;">
                                @foreach(__('service.ingame.' . $service->key . '.requirements') as $requirement)
                                    <li style="color: #9370db;">{{ __('service.' . $requirement) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="item-price">
                            @if($service->currency_type === 'virtual')
                                {{ number_format($service->price) }} {{ config('pw-config.currency_name', 'Coins') }}
                            @else
                                {{ number_format($service->price) }} Gold
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.services.post', $service->key) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    @php
                                        $inputConfig = __('service.ingame.' . $service->key . '.input');
                                    @endphp
                                    
                                    @if(is_array($inputConfig))
                                        <div style="margin-bottom: 15px;">
                                            <input type="{{ $inputConfig['type'] ?? 'text' }}" 
                                                   name="{{ $inputConfig['name'] }}" 
                                                   placeholder="{{ __('service.' . $inputConfig['placeholder']) }}"
                                                   style="width: 100%; background: rgba(26, 15, 46, 0.6); border: 1px solid rgba(147, 112, 219, 0.5); border-radius: 8px; padding: 10px; color: #e6d7f0; font-size: 0.95rem; font-family: Arial, sans-serif;"
                                                   required>
                                        </div>
                                    @endif
                                    
                                    <button type="submit" class="purchase-button">
                                        Use Service
                                    </button>
                                </form>
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">Select a character to use service</p>
                            @endif
                        @else
                            <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">Login to use services</p>
                        @endauth
                    </div>
                @endforeach
            </div>
            @elseif($tab === 'services')
            <div style="text-align: center; padding: 60px 20px;">
                <span style="font-size: 4rem; display: block; margin-bottom: 20px;">⚡</span>
                <p style="font-size: 1.5rem; color: #9370db; margin-bottom: 10px;">No Services Available</p>
                <p style="color: #b19cd9;">Check back later for character services!</p>
            </div>
            @endif
            
            @guest
            <div class="login-notice">
                <p>Please <a href="{{ route('login') }}">login</a> to access the shop</p>
            </div>
            @endguest
        </div>

        @php
            $footerSettings = \App\Models\FooterSetting::first();
            $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Enhance your journey with mystical items</p>';
            $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.';
            $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
        @endphp
        <div class="footer footer-{{ $footerAlignment }}">
            {!! $footerContent !!}
            <p class="footer-text">{!! $footerCopyright !!}</p>
        </div>
    </div>

    <script>
        // Toggle character dropdown
        function toggleCharSelect(event) {
            event.preventDefault();
            const dropdown = document.getElementById('charDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('charDropdown');
            const selector = document.querySelector('.character-selector');
            if (dropdown && !selector.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

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
        
        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('[data-notification]');
            notifications.forEach(function(notification) {
                setTimeout(function() {
                    notification.style.transition = 'opacity 0.5s ease-out';
                    notification.style.opacity = '0';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
        
        // Toggle voucher history popup
        function toggleVoucherHistory() {
            const popup = document.getElementById('voucherHistoryPopup');
            if (popup) {
                popup.style.display = popup.style.display === 'none' ? 'block' : 'none';
                if (popup.style.display === 'block') {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            }
        }
        
        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('voucherHistoryPopup');
            if (popup && event.target === popup) {
                toggleVoucherHistory();
            }
        });
    </script>
    @livewireScripts
</body>
</html>