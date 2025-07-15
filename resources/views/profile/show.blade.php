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
            position: relative;
            overflow-x: hidden;
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

        /* Dragon Ornaments */
        .dragon-ornament {
            position: absolute;
            width: 200px;
            height: 200px;
            opacity: 0.1;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 400'%3E%3Cpath d='M200 50c-50 0-100 50-100 100s50 100 100 100 100-50 100-100-50-100-100-100zm0 20c40 0 80 40 80 80s-40 80-80 80-80-40-80-80 40-80 80-80z' fill='%239370db' /%3E%3Cpath d='M150 100c-20 0-40 20-40 40s20 40 40 40 40-20 40-40-20-40-40-40zm100 0c-20 0-40 20-40 40s20 40 40 40 40-20 40-40-20-40-40-40z' fill='%238a2be2' /%3E%3Cpath d='M200 150c-30 0-60 30-60 60s30 60 60 60 60-30 60-60-30-60-60-60z' fill='%239370db' opacity='0.5' /%3E%3C/svg%3E") no-repeat center;
            animation: float-ornament 20s infinite ease-in-out;
        }

        .dragon-ornament.left {
            left: -50px;
            top: 20%;
        }

        .dragon-ornament.right {
            right: -50px;
            top: 60%;
            animation-delay: -10s;
        }

        @keyframes float-ornament {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
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
        }
        
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        .status-text {
            color: #e6d7f0;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-indicator.online .status-dot {
            background-color: #10b981;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.8);
        }
        
        .status-indicator.offline .status-dot {
            background-color: #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.8);
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .players-online {
            color: #b19cd9;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .players-online i {
            color: #9370db;
        }

        /* Login Box */
        .login-box-wrapper {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
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
            color: #9370db;
            font-size: 1rem;
            margin: 0;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .collapse-toggle {
            background: none;
            border: none;
            color: #9370db;
            font-size: 0.8rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .login-box.collapsed .collapse-toggle {
            transform: rotate(180deg);
        }
        
        .login-box-content {
            padding: 15px;
            max-height: 350px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .login-box.collapsed .login-box-content {
            max-height: 0;
            padding: 0 15px;
        }

        .login-box-content h3 {
            color: #9370db;
            font-size: 1.2rem;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .user-name {
            color: #9370db;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .login-form input {
            background: rgba(26, 15, 46, 0.8);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 5px;
            padding: 8px 12px;
            color: #e6d7f0;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .login-form input:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 0 0 10px rgba(147, 112, 219, 0.3);
        }
        
        .login-form input::placeholder {
            color: #7a6b87;
        }
        
        .login-button {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border: none;
            border-radius: 5px;
            padding: 10px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.5);
        }
        
        .login-links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(147, 112, 219, 0.2);
        }
        
        .login-links a {
            color: #b19cd9;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .login-links a:hover {
            color: #9370db;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.6);
        }
        
        .user-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .user-link {
            background: rgba(147, 112, 219, 0.1);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 5px;
            padding: 8px 12px;
            text-align: center;
            color: #e6d7f0;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .user-link:hover {
            background: rgba(147, 112, 219, 0.2);
            border-color: #9370db;
            transform: translateX(3px);
        }

        /* Nav Bar */
        .nav-bar {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 15px 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            transition: width 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #9370db;
            text-shadow: 0 0 15px rgba(147, 112, 219, 0.8);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Nav Dropdown */
        .nav-dropdown {
            position: relative;
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
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 10px 0;
            margin-top: 10px;
            min-width: 200px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .nav-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
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

        /* Container */
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

        /* Header */
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
            animation: gradientFlow 8s ease infinite;
            text-shadow: 0 0 60px rgba(147, 112, 219, 0.6);
            margin-bottom: 20px;
            display: block;
            line-height: 1;
        }

        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .tagline {
            color: #b19cd9;
            font-size: 1.3rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.5);
        }

        .mystical-border {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            border: 3px solid transparent;
            border-image: linear-gradient(45deg, transparent, #9370db, #8a2be2, #9370db, transparent) 1;
            pointer-events: none;
            animation: borderRotate 10s linear infinite;
        }

        @keyframes borderRotate {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header-center {
            text-align: center;
        }

        .header-left {
            text-align: left;
        }

        .header-right {
            text-align: right;
        }

        /* Profile Section Styling */
        .profile-section {
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

        .profile-section::before {
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

        /* Page Title with ornament */
        .page-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 40px rgba(147, 112, 219, 0.8);
            letter-spacing: 3px;
            margin-bottom: 15px;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .page-subtitle {
            color: #b19cd9;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .ornamental-divider {
            width: 300px;
            height: 2px;
            margin: 30px auto;
            background: linear-gradient(90deg, transparent, #9370db, #8a2be2, #9370db, transparent);
            position: relative;
        }

        .ornamental-divider::before,
        .ornamental-divider::after {
            content: '◆';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #9370db;
            font-size: 1.2rem;
        }

        .ornamental-divider::before {
            left: -20px;
        }

        .ornamental-divider::after {
            right: -20px;
        }

        /* Profile Grid Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Profile Sidebar */
        .profile-sidebar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.15));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            text-align: center;
            position: sticky;
            top: 30px;
            height: fit-content;
        }

        .profile-avatar-section {
            margin-bottom: 30px;
        }

        .profile-avatar-wrapper {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            position: relative;
            border-radius: 50%;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            padding: 4px;
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.5);
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #1a0f2e;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-username {
            font-size: 1.8rem;
            font-weight: 700;
            color: #9370db;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .profile-email {
            color: #b19cd9;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .profile-stats {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .stat-item {
            background: rgba(147, 112, 219, 0.1);
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(147, 112, 219, 0.2);
            transform: translateX(5px);
        }

        .stat-label {
            color: #b19cd9;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #e6d7f0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Profile Content Area */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* User Info Bar */
        .user-info-bar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.1));
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .user-balance {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .balance-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .balance-icon {
            font-size: 1.5rem;
        }

        .balance-label {
            color: #b19cd9;
            font-size: 0.95rem;
        }

        .balance-value {
            color: #9370db;
            font-size: 1.2rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.6);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(147, 112, 219, 0.2);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.4);
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e6d7f0;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.5);
        }

        .section-description {
            color: #b19cd9;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #e6d7f0;
            margin-bottom: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            background: rgba(26, 15, 46, 0.8);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            padding: 15px 20px;
            color: #e6d7f0;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #9370db;
            background: rgba(26, 15, 46, 0.9);
            box-shadow: 0 0 0 4px rgba(147, 112, 219, 0.2),
                        0 0 20px rgba(147, 112, 219, 0.4);
        }

        .form-input::placeholder {
            color: #7a6b87;
        }

        /* Fancy Buttons */
        .btn {
            border: none;
            border-radius: 15px;
            padding: 15px 35px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: white;
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid #9370db;
            color: #9370db;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(147, 112, 219, 0.2);
            border-color: #8a2be2;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.3);
        }

        .btn-danger {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 5px 20px rgba(220, 38, 38, 0.4);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.6);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid rgba(147, 112, 219, 0.2);
            justify-content: flex-end;
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
        
        /* Fix form section backgrounds to be transparent */
        .bg-white.sm\\:p-6 {
            background: transparent !important;
            box-shadow: none !important;
        }
        
        .bg-gray-50.text-right {
            background: transparent !important;
        }
        
        /* Fix grid layout for avatar section */
        .grid.grid-cols-6 {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.5rem !important;
        }
        
        /* Constrain avatar section */
        .col-span-6 {
            width: auto !important;
            max-width: fit-content !important;
        }
        
        /* Success message styling - target action-message component */
        [x-show="shown"] {
            background: #10b981 !important;
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            display: inline-block !important;
            margin-right: 1rem !important;
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
                top: 60px;
                right: 10px;
                left: 10px;
                width: auto;
            }
            
            .login-box {
                width: 100%;
            }
            
            .profile-section {
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

            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <!-- Dragon Ornaments -->
    <div class="dragon-ornament left"></div>
    <div class="dragon-ornament right"></div>

    @php
        $api = new \hrace009\PerfectWorldAPI\API;
        $onlineCount = $api->online ? \App\Models\Player::count() : 0;
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
                            @if(config('pw-config.player_dashboard_enabled', true))
                            <a href="{{ route('app.dashboard') }}" class="user-link">My Dashboard</a>
                            @endif
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
                
                <a href="{{ route('profile.show') }}" class="nav-link active">Profile</a>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Account</h1>
            <p class="page-subtitle">Manage your profile settings and preferences</p>
            <div class="ornamental-divider"></div>
        </div>

        <!-- Success Notification -->
        <div id="success-notification" style="display: none; position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 9999; background: linear-gradient(45deg, #10b981, #059669); color: white; padding: 20px 40px; border-radius: 15px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <i class="fas fa-check-circle"></i> Settings saved successfully! Refreshing page...
        </div>

        <!-- Profile Grid Layout -->
        <div class="profile-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-avatar-section">
                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar">
                            @if (Auth::user()->profile_photo_path)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @else
                                <i class="fas fa-user" style="font-size: 3rem; color: #9370db;"></i>
                            @endif
                        </div>
                    </div>
                    <h2 class="profile-username">{{ Auth::user()->truename ?? Auth::user()->name }}</h2>
                    <p class="profile-email">{{ Auth::user()->email }}</p>
                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-label">Member Since</div>
                        <div class="stat-value">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Account Status</div>
                        <div class="stat-value">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Last Login</div>
                        <div class="stat-value">{{ Auth::user()->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="profile-content">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div class="profile-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h3 class="section-title">Profile Information</h3>
                                <p class="section-description">Update your account's profile information and email address</p>
                            </div>
                        </div>
                        @livewire('profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="profile-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h3 class="section-title">Update Password</h3>
                                <p class="section-description">Ensure your account is using a long, random password to stay secure</p>
                            </div>
                        </div>
                        @livewire('profile.update-password-form')
                    </div>

                    <div class="profile-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <h3 class="section-title">PIN Settings</h3>
                                <p class="section-description">Manage your account PIN for additional security</p>
                            </div>
                        </div>
                        @livewire('profile.pin-settings')
                    </div>
                @endif

                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h3 class="section-title">Browser Sessions</h3>
                            <p class="section-description">Manage and log out your active sessions on other browsers and devices</p>
                        </div>
                    </div>
                    @livewire('profile.logout-from-other-browser')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="profile-section">
                        <div class="section-header">
                            <div class="section-icon" style="background: linear-gradient(45deg, #dc2626, #b91c1c);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h3 class="section-title">Delete Account</h3>
                                <p class="section-description">Permanently delete your account</p>
                            </div>
                        </div>
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>

        @if ( $api->online )
            <div class="profile-section" style="margin-top: 40px;">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="section-title">My Characters</h3>
                        <p class="section-description">View and manage your in-game characters</p>
                    </div>
                </div>
                @livewire('profile.list-character')
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
            function showSuccessAndRefresh() {
                // Show notification
                const notification = document.getElementById('success-notification');
                if (notification) {
                    notification.style.display = 'block';
                }
                
                // Refresh after 5 seconds
                setTimeout(function() {
                    window.location.reload();
                }, 5000);
            }
            
            // For Livewire v2
            if (typeof Livewire !== 'undefined') {
                Livewire.on('saved', showSuccessAndRefresh);
                
                // Also listen for profile updated event
                Livewire.on('profile-updated', showSuccessAndRefresh);
            }
            
            // For Livewire v3
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('saved', showSuccessAndRefresh);
                Livewire.on('profile-updated', showSuccessAndRefresh);
            });
        });

        // Toggle login box
        function toggleLoginBox() {
            const loginBox = document.getElementById('loginBox');
            loginBox.classList.toggle('collapsed');
        }

        // Auto-collapse login box if user is logged in
        document.addEventListener('DOMContentLoaded', function() {
            @if(Auth::check())
            const loginBox = document.getElementById('loginBox');
            loginBox.classList.add('collapsed');
            @endif
        });

        // Pin field auto-show based on URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('requires_pin') === 'true') {
            const pinField = document.getElementById('pin-field');
            if (pinField) {
                pinField.style.display = 'block';
                pinField.focus();
            }
        }
    </script>
    
    <x-hrace009::front.bottom-script/>
    @livewireScripts
</body>
</html>