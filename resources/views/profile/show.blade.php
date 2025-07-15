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

        /* Header */
        .header {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(147, 112, 219, 0.3);
            padding: 25px 60px;
            position: relative;
            z-index: 1000;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.5);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
            letter-spacing: 2px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-button {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.2), rgba(138, 43, 226, 0.2));
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 12px 25px;
            color: #e6d7f0;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .nav-button:hover::before {
            left: 100%;
        }

        .nav-button:hover {
            background: linear-gradient(45deg, rgba(147, 112, 219, 0.3), rgba(138, 43, 226, 0.3));
            border-color: #9370db;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }

        .nav-button i {
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px;
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

        /* Profile Sections */
        .profile-section {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.15));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .profile-section::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db);
            border-radius: 25px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .profile-section:hover::before {
            opacity: 0.3;
        }

        .profile-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(147, 112, 219, 0.4);
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
    
    <!-- Dragon Ornaments -->
    <div class="dragon-ornament left"></div>
    <div class="dragon-ornament right"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="header-title">PROFILE CENTER</h1>
            </div>
            
            <div class="user-info">
                <div class="character-selector">
                    <span class="character-selector-label">Character:</span>
                    <x-hrace009::character-selector/>
                </div>
                
                <div class="balance-display">
                    <x-hrace009::balance/>
                </div>
                
                <div class="nav-buttons">
                    <a href="{{ route('HOME') }}" class="nav-button">
                        <i class="fas fa-home"></i> Home
                    </a>
                    @if(Auth::user()->isAdministrator())
                    <a href="{{ route('admin.dashboard') }}" class="nav-button">
                        <i class="fas fa-crown"></i> Admin
                    </a>
                    @endif
                </div>
                
                <div class="user-avatar">
                    <x-hrace009::user-avatar/>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
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
                        <div class="stat-value">{{ Auth::user()->email_verified_at ? 'Verified' : 'Unverified' }}</div>
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
    </script>
    
    <x-hrace009::front.bottom-script/>
    @livewireScripts
</body>
</html>