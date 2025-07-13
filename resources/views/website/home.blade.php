<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            position: fixed;
            top: 100px;  /* Position below server status with smaller gap */
            left: 20px;
            z-index: 100;
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
            max-height: 400px;  /* Limit max height */
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

        /* Visit Reward Widget */
        .visit-reward-wrapper {
            position: fixed;
            top: 420px;
            left: 20px;
            z-index: 100;
            width: 220px;
        }
        
        .visit-reward-box {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(255, 215, 0, 0.2));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 215, 0, 0.4);
            border-radius: 10px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .visit-reward-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.3);
            cursor: pointer;
            background: rgba(255, 215, 0, 0.1);
        }
        
        .visit-reward-header h3 {
            margin: 0;
            color: #ffd700;
            font-size: 1rem;
            text-shadow: 0 0 15px rgba(255, 215, 0, 0.6);
        }
        
        .visit-reward-content {
            padding: 10px 15px;
            text-align: center;
        }
        
        .visit-reward-box.collapsed .visit-reward-content {
            display: none;
        }
        
        .visit-reward-box.collapsed .collapse-toggle {
            transform: rotate(180deg);
        }
        
        .reward-icon {
            font-size: 1.8rem;
            margin-bottom: 5px;
            display: block;
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .reward-title {
            color: #ffd700;
            font-size: 1.1rem;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .reward-description {
            color: #ffed4e;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }
        
        .reward-amount {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .claim-button {
            width: 100%;
            background: linear-gradient(45deg, #ffd700, #ffa500);
            color: #4a0e4e;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .claim-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
        }
        
        .claim-button:disabled {
            background: linear-gradient(45deg, #6c757d, #495057);
            cursor: not-allowed;
            transform: none;
        }
        
        .reward-timer {
            color: #ffed4e;
            font-size: 0.9rem;
            margin-top: 10px;
        }
        
        .countdown-display {
            font-family: monospace;
            font-size: 1.1rem;
            color: #ffd700;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 3rem;
            }
            
            .login-box-wrapper,
            .visit-reward-wrapper {
                position: relative;
                top: auto;
                left: auto;
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

        /* Server Status */
        .server-status {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;  /* Reduced from 1000 to avoid blocking dropdowns */
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 10px;
            padding: 10px 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 220px;  /* Smaller width */
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
        
        @media (max-width: 768px) {
            .server-status {
                position: fixed;  /* Keep it fixed on mobile too */
                top: 10px;
                left: 10px;
                right: 10px;  /* Make it responsive width on mobile */
                padding: 10px 15px;  /* Smaller padding on mobile */
                font-size: 0.9rem;  /* Slightly smaller text */
            }
            
            .status-text {
                font-size: 1rem;
            }
            
            .players-online {
                font-size: 0.85rem;
            }
            
            .login-box-wrapper {
                position: fixed;
                top: 90px;  /* Position below server status on mobile too */
                left: 10px;
                right: 10px;
                width: auto;
                max-width: 300px;  /* Limit width on mobile */
            }
            
            .login-box {
                width: 100%;
            }
        }

    </style>
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
        $visitRewardSettings = \App\Models\VisitRewardSetting::first();
    @endphp
    
    @if($visitRewardSettings && $visitRewardSettings->enabled && Auth::check())
    <!-- Visit Reward Widget -->
    <div class="visit-reward-wrapper">
        <div class="visit-reward-box" id="visitRewardBox">
            <div class="visit-reward-header" onclick="toggleVisitRewardBox()">
                <h3>{{ $visitRewardSettings->title }}</h3>
                <button class="collapse-toggle">▼</button>
            </div>
            <div class="visit-reward-content">
                <span class="reward-icon">🎁</span>
                @if($visitRewardSettings->description)
                    <p class="reward-description">{{ $visitRewardSettings->description }}</p>
                @endif
                <div class="reward-amount">
                    +{{ $visitRewardSettings->reward_amount }}
                    @if($visitRewardSettings->reward_type == 'virtual')
                        {{ config('pw-config.currency_name', 'Coins') }}
                    @elseif($visitRewardSettings->reward_type == 'cubi')
                        Gold
                    @else
                        Bonus Points
                    @endif
                </div>
                <button class="claim-button" id="claimRewardBtn" onclick="claimVisitReward()" disabled>
                    Loading...
                </button>
                <div class="reward-timer" id="rewardTimer" style="display: none;">
                    Next reward in: <span class="countdown-display" id="rewardCountdown">--:--:--</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    
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
                
                <a href="{{ route('public.members') }}" class="nav-link {{ Route::is('public.members') ? 'active' : '' }}">Members</a>
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
                            <h3 class="news-title"><a href="javascript:void(0)" onclick="openNewsPopup('{{ $article->slug }}')">{{ $article->title }}</a></h3>
                            <div class="news-meta">
                                <span class="news-date">📅 {{ $article->date( $article->created_at ) }}</span>
                                <span class="news-category">{{ __('news.category.' . $article->category) }}</span>
                            </div>
                            <p class="news-description">{{ Str::limit($article->description, 150) }}</p>
                            <a href="javascript:void(0)" onclick="openNewsPopup('{{ $article->slug }}')" class="read-more-btn">Read More</a>
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

    <!-- News Article Popup -->
    <div id="newsPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); z-index: 10000; overflow-y: auto; padding: 20px;">
        <div style="position: relative; max-width: 900px; margin: 50px auto; background: linear-gradient(135deg, #1a0f2e, #2a1b3d); border: 2px solid rgba(147, 112, 219, 0.4); border-radius: 20px; padding: 40px; box-shadow: 0 20px 60px rgba(147, 112, 219, 0.6); color: #e6d7f0;">
            <button onclick="closeNewsPopup()" style="position: absolute; top: 20px; right: 20px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 50%; width: 40px; height: 40px; color: #ef4444; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease; z-index: 1; line-height: 1;">
                ×
            </button>
            
            <div id="newsContent" style="font-family: Arial, sans-serif;">
                <!-- Article content will be loaded here -->
            </div>
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

        // News popup functions
        function openNewsPopup(slug) {
            const popup = document.getElementById('newsPopup');
            const content = document.getElementById('newsContent');
            
            // Show loading state
            content.innerHTML = '<div style="text-align: center; padding: 40px;"><div style="font-size: 3rem; animation: spin 1s linear infinite;">⏳</div><p style="margin-top: 20px; color: #b19cd9;">Loading article...</p></div>';
            
            // Show popup
            popup.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            // Fetch article content
            fetch('/api/news/' + slug)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        content.innerHTML = `
                            <span class="news-icon" style="font-size: 3rem; display: block; text-align: center; margin-bottom: 20px;">
                                ${data.article.category === 'update' ? '✨' : 
                                  data.article.category === 'event' ? '🎆' : 
                                  data.article.category === 'maintenance' ? '🔧' : '📜'}
                            </span>
                            <h1 style="font-size: 2.5rem; color: #9370db; text-align: center; margin-bottom: 20px; text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);">${data.article.title}</h1>
                            <div style="text-align: center; margin-bottom: 30px;">
                                <span style="color: #b19cd9; margin-right: 20px;">📅 ${data.article.date}</span>
                                <span style="background: rgba(147, 112, 219, 0.2); padding: 5px 15px; border-radius: 20px; color: #dda0dd;">${data.article.category}</span>
                            </div>
                            <div style="line-height: 1.8; font-size: 1.1rem;">${data.article.content}</div>
                            ${data.article.author ? '<p style="text-align: right; margin-top: 30px; color: #b19cd9; font-style: italic;">— ' + data.article.author + '</p>' : ''}
                        `;
                    } else {
                        content.innerHTML = '<div style="text-align: center; padding: 40px;"><p style="color: #ef4444;">Failed to load article</p></div>';
                    }
                })
                .catch(error => {
                    content.innerHTML = '<div style="text-align: center; padding: 40px;"><p style="color: #ef4444;">Error loading article</p></div>';
                });
        }
        
        function closeNewsPopup() {
            const popup = document.getElementById('newsPopup');
            popup.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('newsPopup');
            if (event.target === popup) {
                closeNewsPopup();
            }
        });
        
        // Add CSS animation for spinner
        const spinnerStyle = document.createElement('style');
        spinnerStyle.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(spinnerStyle);
        
        // Visit Reward Functions
        function toggleVisitRewardBox() {
            const rewardBox = document.getElementById('visitRewardBox');
            rewardBox.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = rewardBox.classList.contains('collapsed');
            localStorage.setItem('visitRewardBoxCollapsed', isCollapsed);
        }
        
        // Restore visit reward box state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const rewardBox = document.getElementById('visitRewardBox');
            if (rewardBox) {
                const savedState = localStorage.getItem('visitRewardBoxCollapsed');
                if (savedState === 'true') {
                    rewardBox.classList.add('collapsed');
                }
                
                // Check reward status
                checkVisitRewardStatus();
            }
        });
        
        let rewardCountdownInterval = null;
        
        function checkVisitRewardStatus() {
            fetch('/api/visit-reward/status', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Not authorized');
                    }
                    return response.json();
                })
                .then(data => {
                    const claimBtn = document.getElementById('claimRewardBtn');
                    const timerDiv = document.getElementById('rewardTimer');
                    const countdownSpan = document.getElementById('rewardCountdown');
                    
                    if (!data.enabled) {
                        claimBtn.textContent = 'Rewards Disabled';
                        claimBtn.disabled = true;
                        return;
                    }
                    
                    if (data.can_claim) {
                        claimBtn.textContent = 'Claim Reward';
                        claimBtn.disabled = false;
                        timerDiv.style.display = 'none';
                        
                        // Clear any existing countdown
                        if (rewardCountdownInterval) {
                            clearInterval(rewardCountdownInterval);
                            rewardCountdownInterval = null;
                        }
                    } else {
                        claimBtn.textContent = 'Already Claimed';
                        claimBtn.disabled = true;
                        timerDiv.style.display = 'block';
                        
                        // Start countdown
                        startRewardCountdown(data.seconds_until_next);
                    }
                })
                .catch(error => {
                    console.error('Error checking reward status:', error);
                    const claimBtn = document.getElementById('claimRewardBtn');
                    if (error.message === 'Not authorized') {
                        claimBtn.textContent = 'Login Required';
                    } else {
                        claimBtn.textContent = 'Error';
                    }
                    claimBtn.disabled = true;
                });
        }
        
        function startRewardCountdown(seconds) {
            const countdownSpan = document.getElementById('rewardCountdown');
            let remainingSeconds = seconds;
            
            // Clear any existing countdown
            if (rewardCountdownInterval) {
                clearInterval(rewardCountdownInterval);
            }
            
            function updateCountdown() {
                if (remainingSeconds <= 0) {
                    clearInterval(rewardCountdownInterval);
                    checkVisitRewardStatus(); // Recheck status when timer expires
                    return;
                }
                
                const hours = Math.floor(remainingSeconds / 3600);
                const minutes = Math.floor((remainingSeconds % 3600) / 60);
                const seconds = remainingSeconds % 60;
                
                countdownSpan.textContent = 
                    String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
                
                remainingSeconds--;
            }
            
            updateCountdown(); // Initial update
            rewardCountdownInterval = setInterval(updateCountdown, 1000);
        }
        
        function claimVisitReward() {
            const claimBtn = document.getElementById('claimRewardBtn');
            claimBtn.disabled = true;
            claimBtn.textContent = 'Claiming...';
            
            fetch('/api/visit-reward/claim', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success notification
                    showRewardNotification(data.reward_amount, data.reward_type);
                    
                    // Update button state
                    claimBtn.textContent = 'Claimed!';
                    
                    // Start countdown for next reward
                    setTimeout(() => {
                        checkVisitRewardStatus();
                    }, 2000);
                } else {
                    claimBtn.textContent = data.error || 'Error';
                    setTimeout(() => {
                        checkVisitRewardStatus();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error claiming reward:', error);
                claimBtn.textContent = 'Error';
                setTimeout(() => {
                    checkVisitRewardStatus();
                }, 2000);
            });
        }
        
        function showRewardNotification(amount, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.9), rgba(255, 215, 0, 0.3));
                border: 2px solid #ffd700;
                padding: 30px 50px;
                border-radius: 20px;
                z-index: 10000;
                text-align: center;
                box-shadow: 0 20px 60px rgba(255, 215, 0, 0.6);
                animation: rewardPop 0.5s ease-out;
            `;
            
            let rewardText = amount + ' ';
            if (type === 'virtual') {
                rewardText += '{{ config('pw-config.currency_name', 'Coins') }}';
            } else if (type === 'cubi') {
                rewardText += 'Gold';
            } else {
                rewardText += 'Bonus Points';
            }
            
            notification.innerHTML = `
                <div style="font-size: 3rem; margin-bottom: 10px;">🎁</div>
                <div style="color: #ffd700; font-size: 1.5rem; font-weight: 700; margin-bottom: 10px;">Reward Claimed!</div>
                <div style="color: #ffed4e; font-size: 1.2rem;">+${rewardText}</div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove after animation
            setTimeout(() => {
                notification.style.animation = 'rewardFade 0.5s ease-out';
                setTimeout(() => notification.remove(), 500);
            }, 2000);
        }
        
        // Add animation styles
        const rewardAnimationStyle = document.createElement('style');
        rewardAnimationStyle.textContent = `
            @keyframes rewardPop {
                0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
                50% { transform: translate(-50%, -50%) scale(1.1); }
                100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
            }
            @keyframes rewardFade {
                0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
                100% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
            }
        `;
        document.head.appendChild(rewardAnimationStyle);
    </script>
</body>
</html>
