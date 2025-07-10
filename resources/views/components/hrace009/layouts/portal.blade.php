<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('pw-config.server_name', 'Laravel') }} @yield('title')</title>
    <meta name="description" content="Custom themed homepage for {{ config('pw-config.server_name') }}">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/portal/bootstrap/dist/css/bootstrap.min.css') }}" />
    {{-- FontAwesome for icons --}}
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fontawesome-all.min.js') }}"></script>
    <script defer src="{{ asset('vendor/portal/font-awesome/svg-with-js/js/fa-v4-shims.min.js') }}"></script>
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom-home.css') }}">

    @php
        $userTheme = auth()->check() ? auth()->user()->theme : config('themes.default');
        $themeConfig = config('themes.themes.' . $userTheme);
    @endphp
    
    @if($themeConfig && isset($themeConfig['css']))
        <link rel="stylesheet" href="{{ asset($themeConfig['css']) }}">
    @endif

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        /* Modern Dark Theme Variables */
        :root {
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a3a;
            --bg-tertiary: #2a2a4a;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #334155;
            --card-bg: #1e293b;
            --hover-bg: rgba(99, 102, 241, 0.1);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        /* Global Dark Theme */
        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Custom Navbar Styles */
        .custom-navbar {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            padding: 12px 0;
            min-height: 80px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        /* Ensure navbar items maintain proper order */
        .custom-navbar .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        
        .custom-navbar .nav-item {
            display: flex;
            align-items: center;
        }
        
        /* Ensure all navbar items maintain their order */
        .custom-navbar .navbar-nav > * {
            order: initial;
        }
        
        /* Make nav-item dropdowns behave like inline elements */
        .custom-navbar .nav-item.dropdown {
            display: inline-flex;
        }

        .custom-navbar .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-navbar .navbar-brand img {
            height: 60px;
            width: auto;
        }

        .custom-navbar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .custom-navbar .nav-link:hover, .custom-navbar .nav-link.active { /* Added .active for current page */
            color: #ffd700 !important;
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .custom-navbar .navbar-toggler {
            border-color: rgba(255,255,255,0.3);
            padding: 4px 8px;
        }

        .custom-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Dropdown styles for Download/Guide sections */
        .custom-navbar .dropdown-menu {
            background-color: #6a5acd; /* Slightly different background for dropdown */
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-radius: 8px;
            padding: 10px 0;
        }
        .custom-navbar .dropdown-menu .dropdown-item {
            color: rgba(255,255,255,0.85) !important;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .custom-navbar .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffd700 !important;
        }
        .custom-navbar .dropdown-toggle::after { /* Styling for Bootstrap dropdown caret */
            color: rgba(255,255,255,0.9);
        }

        /* Login Hover Reveal - Enhanced Dark Theme */
        .login-hover-reveal {
            position: relative;
        }

        .login-hover-content {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 28px;
            min-width: 320px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1050;
        }

        /* Glowing arrow pointing up */
        .login-hover-content::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 24px;
            width: 16px;
            height: 16px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-right: none;
            border-bottom: none;
            transform: rotate(45deg);
        }

        .login-hover-reveal:hover .login-hover-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .login-hover-reveal:hover .login-hover-content,
        .login-hover-content:hover {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .login-form {
            color: var(--text-primary);
        }

        .login-form h5 {
            color: var(--accent-primary);
            font-weight: 600;
            margin-bottom: 24px;
        }

        .login-form .form-control {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }

        .login-form .form-control::placeholder {
            color: var(--text-muted);
        }

        .login-form .form-control:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
            background: var(--bg-tertiary);
        }

        .login-form .btn-login {
            background: var(--gradient-accent);
            border: none;
            color: white;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-form .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-form .btn-login:hover::before {
            left: 100%;
        }

        .login-form .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .login-form .btn-register {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-form .btn-register:hover {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
            background: var(--hover-bg);
            transform: translateY(-1px);
        }

        .login-form .form-check-input {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .login-form .form-check-input:checked {
            background-color: var(--accent-primary);
            border-color: var(--accent-primary);
        }

        .login-form .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .login-form .form-check-label {
            color: var(--text-secondary);
        }

        .login-form a {
            color: var(--accent-primary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .login-form a:hover {
            color: var(--accent-secondary);
        }

        .login-divider {
            text-align: center;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: 12px;
            position: relative;
        }

        .login-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
            z-index: -1;
        }

        /* Account link styling - Dark Theme */
        .account-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: var(--text-secondary) !important;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .account-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-accent);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .account-link:hover::before {
            opacity: 0.15;
        }

        .account-link:hover {
            color: var(--text-primary) !important;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* User dropdown for logged in users - Dark Theme */
        .user-dropdown-content {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 24px;
            min-width: 280px;
            color: var(--text-primary);
        }

        .user-dropdown-content .btn {
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 14px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .user-dropdown-content .btn:last-child {
            margin-bottom: 0;
        }

        .user-dropdown-content .btn-outline-primary {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
        }

        .user-dropdown-content .btn-outline-primary:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-1px);
        }

        .user-dropdown-content .btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .user-dropdown-content .btn-outline-secondary:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        .user-dropdown-content .btn-outline-info {
            color: #06b6d4;
            border-color: #06b6d4;
        }

        .user-dropdown-content .btn-outline-info:hover {
            background: #06b6d4;
            color: white;
            transform: translateY(-1px);
        }

        .user-dropdown-content .btn-outline-danger {
            color: #ef4444;
            border-color: #ef4444;
        }

        .user-dropdown-content .btn-outline-danger:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-1px);
        }

        /* Main Content Area - Dark Theme */
        .custom-home-content-wrap {
            background: var(--bg-primary);
            min-height: calc(100vh - 140px); /* Adjust based on navbar and footer height */
            padding: 40px 0;
        }

        .container { /* Ensure this doesn't conflict with Bootstrap's .container if used elsewhere */
            max-width: 1200px; /* Or your preferred max width */
            margin: 0 auto;
            padding: 0 20px; /* Side padding for content within the container */
        }

        .main-content-area {
            float: left;
            width: 70%; /* Adjust as needed */
            padding-right: 30px; /* Space between main content and sidebar */
            box-sizing: border-box;
        }

        .sidebar-area {
            float: right;
            width: 30%; /* Adjust as needed */
            padding-left: 30px; /* Space between main content and sidebar */
            box-sizing: border-box;
        }

        /* Clearfix for container if children are floated */
        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        h2, h3 {
            color: var(--text-primary);
            font-weight: 600;
        }

        h2 { /* Styling for "Latest News" */
            border-bottom: 3px solid var(--accent-primary);
            padding-bottom: 12px;
            margin-bottom: 30px;
            font-size: 2rem;
            /* Optional: Gradient text for h2 */
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .news-article-item {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 28px;
            margin-bottom: 24px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden; /* For the ::before pseudo-element */
        }

        .news-article-item::before { /* Top border accent */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-accent); /* Or var(--accent-primary) for solid */
        }

        .news-article-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-primary); /* Optional: change border on hover */
        }

        .news-article-item h3 a {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 600; /* Or your preferred weight */
            transition: color 0.3s ease;
        }

        .news-article-item h3 a:hover {
            color: var(--accent-primary);
        }

        .article-meta {
            font-size: 0.9em;
            color: var(--text-muted);
            margin-bottom: 16px;
            display: flex; /* For aligning items like date and category */
            gap: 20px; /* Space between meta items */
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .article-meta .date, .article-meta .category {
            display: flex;
            align-items: center;
            gap: 6px; /* Space between icon and text */
        }

        .article-meta .label { /* For category labels */
            padding: 4px 12px;
            border-radius: 20px; /* Pill shape */
            font-size: 12px;
            font-weight: 500;
        }

        .article-meta .label a {
            color: white !important; /* Ensure text is readable on colored labels */
            text-decoration: none;
        }

        .article-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
        }

        .article-tags {
            font-size: 0.9em;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .article-tags a {
            color: var(--accent-primary);
            text-decoration: none;
            padding: 4px 8px;
            background: var(--hover-bg);
            border-radius: 4px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .article-tags a:hover {
            background: var(--accent-primary);
            color: white;
        }

        .article-description {
            margin-bottom: 20px;
            color: var(--text-secondary);
            line-height: 1.6; /* Or 1.7 for more spacing */
        }

        .read-more {
            display: inline-flex; /* For aligning icon and text */
            align-items: center;
            gap: 8px;
            background: var(--gradient-accent);
            color: white !important;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none; /* Remove default button border */
        }

        .read-more:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .pagination-links nav { /* Assuming Laravel pagination renders a nav element */
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .sidebar-area {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 28px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        .sidebar-area h4 {
            color: var(--text-primary);
            margin-bottom: 20px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-primary);
        }
            font-size: 14px;
            padding: 8px 12px;
            margin-bottom: 5px;
        }

        .user-dropdown-content .btn:last-child {
            margin-bottom: 0;
        }

        /* Mobile responsiveness */
        @media (max-width: 991px) {
            .login-hover-content {
                position: static; /* Change from absolute for mobile */
                opacity: 1;
                visibility: visible;
                transform: none;
                margin-top: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }

            .login-hover-content::before { /* Hide arrow on mobile */
                display: none;
            }

            .custom-navbar .navbar-nav {
                padding-top: 10px; /* Space above nav items when collapsed */
            }

            .custom-navbar .nav-link, .custom-navbar .nav-item .dropdown-toggle { /* Apply to dropdown toggles too */
                margin: 2px 0;
                text-align: center; /* Center links in mobile view */
            }

            .main-content-area,
            .sidebar-area {
                float: none;
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .sidebar-area {
                margin-top: 30px; /* Space above sidebar on mobile */
            }
        }

        /* Logo styling */
        .navbar-logo {
            height: 60px !important; /* Increased size for better readability */
            width: auto;
            margin-right: 10px; /* Adjusted gap */
        }
        
        .navbar-badge {
            cursor: default;
            pointer-events: none;
        }
        
        /* Header Section */
        .site-header {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            padding: 30px 0;
            text-align: center;
            border-bottom: 2px solid var(--accent-primary);
            box-shadow: var(--shadow-lg);
        }
        
        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .header-logo {
            max-height: 120px;
            width: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5));
            transition: transform 0.3s ease;
        }
        
        .header-logo:hover {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .site-header {
                padding: 20px 0;
            }
            
            .header-logo {
                max-height: 80px;
            }
        }

        /* Widget Styling for Dark Theme */
        .sidebar-area .side-block {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px; /* Consistent with news articles */
            padding: 20px;
            margin-bottom: 24px; /* Consistent spacing */
            box-shadow: var(--shadow-md);
        }

        .sidebar-area .side-block .block-title {
            color: var(--text-primary);
            font-size: 1.25rem; /* Slightly smaller than main h2 */
            font-weight: 600;
            padding-bottom: 10px;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--accent-secondary); /* Different accent for widgets */
            background: var(--gradient-accent); /* Optional: Gradient text for widget titles */
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-area .side-block .block-content {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 10px; /* Space between content lines in server status */
        }

        .sidebar-area .side-block .block-content:last-child {
            margin-bottom: 0;
        }

        .sidebar-area .side-block .block-content .label,
        .sidebar-area .side-block .block-content .badge {
            background-color: var(--accent-primary) !important; /* Important to override default badge colors */
            color: white !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .sidebar-area .side-block .block-content .bg-success {
            background-color: #28a745 !important; /* Keep success color distinct if needed, or use accent */
        }
        .sidebar-area .side-block .block-content .bg-danger {
            background-color: #dc3545 !important; /* Keep danger color distinct */
        }

        /* GM List Table */
        .sidebar-area .table-gmlist {
            width: 100%;
            color: var(--text-secondary);
        }
        .sidebar-area .table-gmlist td {
            padding: 8px 4px;
            vertical-align: middle;
            border-top: 1px solid var(--border-color); /* Subtle separators */
        }
        .sidebar-area .table-gmlist tr:first-child td {
            border-top: none;
        }
        .sidebar-area .table-gmlist img.img-rounded {
            border-radius: 50%; /* Make GM avatars circular */
            border: 2px solid var(--border-color);
        }

        /* News Category Links in Widget */
        .sidebar-area .side-block ul.block-content { /* Target the UL specifically for category list */
            list-style: none;
            padding-left: 0;
        }
        .sidebar-area .side-block ul.block-content a {
            display: block;
            color: var(--accent-secondary);
            text-decoration: none;
            padding: 6px 0;
            border-bottom: 1px dashed var(--border-color); /* Dashed separator for links */
            transition: color 0.3s ease, padding-left 0.3s ease;
        }
        .sidebar-area .side-block ul.block-content a:hover {
            color: var(--accent-primary);
            padding-left: 5px; /* Slight indent on hover */
        }
        .sidebar-area .side-block ul.block-content a:last-child {
            border-bottom: none;
        }
        
        /* Fix: Hide navbar toggler on desktop screens - more aggressive */
        @media (min-width: 992px) {
            .custom-navbar .navbar-toggler {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                width: 0 !important;
                height: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                border: 0 !important;
                position: absolute !important;
                left: -9999px !important;
            }
        }
        
        /* Debug: Help identify mystery element */
        .custom-navbar * {
            position: relative;
        }
        
        /* Make sure navbar-brand doesn't overflow */
        .custom-navbar .navbar-brand {
            position: relative;
            z-index: 1;
            flex: 0 0 auto; /* Don't grow or shrink */
            max-width: fit-content; /* Only take up space needed */
        }
        
        .custom-navbar .navbar-nav {
            position: relative;
            z-index: 1;
        }
        
        /* Ensure no elements overflow outside navbar */
        .custom-navbar {
            overflow: visible; /* For dropdowns */
        }
        
        .custom-navbar .navbar-collapse {
            position: relative;
        }
        
        /* Ensure navbar brand doesn't have any invisible clickable area */
        .custom-navbar .navbar-brand * {
            pointer-events: none;
        }
        
        .custom-navbar .navbar-brand {
            pointer-events: auto;
        }
        
        /* Fix dropdown menus in navbar */
        .custom-navbar .dropdown-menu {
            display: none;
            position: absolute;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            margin-top: 10px;
        }
        
        .custom-navbar .dropdown-menu.show {
            display: block;
        }
        
        .custom-navbar .dropdown-menu .dropdown-item {
            color: var(--text-primary);
        }
        
        .custom-navbar .dropdown-menu .dropdown-item:hover {
            background: var(--hover-bg);
            color: var(--accent-primary);
        }
        

    </style>
    @if( config('pw-config.logo') === 'img/logo/logo.png' )
        <link rel="shortcut icon" href="{{ asset(config('pw-config.logo')) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset(config('pw-config.logo')) }}"
        />
    @elseif( ! config('pw-config.logo') )
        <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('img/logo/logo.png') }}"
        />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"/>
        <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}"
        />
    @endif
    {{-- Removed <x-hrace009::portal.top-script/> as scripts are now at the bottom or included in head --}}
</head>
<body class="theme-{{ $userTheme }}">
    {{-- Language Selector and Theme Toggle - Fixed Position, Top Right --}}
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1100; display: flex; align-items: center; gap: 10px;">
        @if(Auth::check())
            @livewire('theme-selector')
        @endif
        <x-home-theme-toggle />
        <x-hrace009::language-button />
    </div>

    {{-- Header Section --}}
    @php
        $headerSettings = \App\Models\HeaderSetting::first();
        $headerLogo = $headerSettings && $headerSettings->header_logo ? $headerSettings->header_logo : config('pw-config.header_logo', 'img/logo/haven_perfect_world_logo.svg');
    @endphp
    <header class="site-header">
        <div class="container-fluid">
            <div class="header-content">
                <img src="{{ asset($headerLogo) }}" alt="{{ config('pw-config.server_name') }}" class="header-logo" onclick="window.location.href='{{ route('HOME') }}'" style="cursor: pointer;">
            </div>
        </div>
    </header>

    {{-- Custom Navbar with Working Hover Login --}}
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
        <div class="navbar-brand">
            @if( !config('pw-config.logo') || config('pw-config.logo') === '' )
                <img src="{{ asset('img/logo/logo.png') }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
            @elseif( str_starts_with(config('pw-config.logo'), 'img/logo/') )
                <img src="{{ asset(config('pw-config.logo')) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
            @else
                <img src="{{ asset('uploads/logo/' . config('pw-config.logo') ) }}" alt="{{ config('pw-config.server_name') }}" class="navbar-logo navbar-badge">
            @endif
        </div>

        {{-- Navbar toggler will be added by JavaScript for mobile only --}}
        <div id="navbar-toggler-placeholder"></div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav me-auto">
                {{-- Home Link --}}
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('HOME') ? 'active' : '' }}" href="{{ route('HOME') }}">
                        <i class="fas fa-home me-1"></i>{{ __('general.home') }}
                    </a>
                </div>

                {{-- Shop Link --}}
                @if( config('pw-config.system.apps.shop') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.shop.index') ? 'active' : '' }}" href="{{ route('app.shop.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>{{ __('shop.title') }}
                    </a>
                </div>
                @endif

                {{-- Donate Link --}}
                @if( config('pw-config.system.apps.donate') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.donate.history') ? 'active' : '' }}" href="{{ route('app.donate.history') }}">
                        <i class="fas fa-credit-card me-1"></i>{{ __('donate.title') }}
                    </a>
                </div>
                @endif

                {{-- Voucher Link --}}
                @if( config('pw-config.system.apps.voucher') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.voucher.index') ? 'active' : '' }}" href="{{ route('app.voucher.index') }}">
                        <i class="fas fa-ticket-alt me-1"></i>{{ __('voucher.title') }}
                    </a>
                </div>
                @endif

                {{-- Ingame Service Link --}}
                @if( config('pw-config.system.apps.inGameService') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.services.index') ? 'active' : '' }}" href="{{ route('app.services.index') }}">
                        <i class="fas fa-tools me-1"></i>{{ __('service.title') }}
                    </a>
                </div>
                @endif

                {{-- Ranking Link --}}
                @if( config('pw-config.system.apps.ranking') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.ranking.index') ? 'active' : '' }}" href="{{ route('app.ranking.index') }}">
                        <i class="fas fa-trophy me-1"></i>{{ __('ranking.title') }}
                    </a>
                </div>
                @endif

                {{-- Vote Link --}}
                @if( config('pw-config.system.apps.vote') )
                <div class="nav-item">
                    <a class="nav-link {{ Route::is('app.vote.index') ? 'active' : '' }}" href="{{ route('app.vote.index') }}">
                        <i class="fas fa-vote-yea me-1"></i>{{ __('vote.title') }}
                    </a>
                </div>
                @endif

                {{-- Extras Dropdown (Custom Pages) --}}
                @php
                    $customPages = \App\Models\Page::active()->inNav()->orderBy('order')->orderBy('title')->get();
                @endphp
                @if($customPages->count() > 0)
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('page.show') ? 'active' : '' }}" href="#" id="extrasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h me-1"></i>{{ __('general.extras') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="extrasDropdown">
                            @foreach($customPages as $page)
                                <li><a class="dropdown-item {{ request()->is('page/' . $page->slug) ? 'active' : '' }}" href="{{ route('page.show', $page->slug) }}">{{ $page->nav_title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Download Links --}}
                @isset($download)
                    @if( $download->exists() && $download->count() > 0 )
                        @if( $download->count() === 1 )
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('show.article', $download->first()->slug ) }}">
                                    <i class="fas fa-download me-1"></i>{{ $download->first()->title }}
                                </a>
                            </div>
                        @else
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="downloadDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download me-1"></i>{{ __('news.category.download') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                    @foreach( $download->get() as $page )
                                        <li><a class="dropdown-item" href="{{ route('show.article', $page->slug ) }}">{{ $page->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @endisset

                {{-- Guide Links --}}
                @isset($guide)
                    @if( $guide->exists() && $guide->count() > 0 )
                        @if( $guide->count() === 1 )
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('show.article', $guide->first()->slug ) }}">
                                    <i class="fas fa-book-open me-1"></i>{{ $guide->first()->title }}
                                </a>
                            </div>
                        @else
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="guideDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-book-open me-1"></i>{{ __('news.category.guide') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="guideDropdown">
                                    @foreach( $guide->get() as $guidepage )
                                        <li><a class="dropdown-item" href="{{ route('show.article', $guidepage->slug ) }}">{{ $guidepage->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @endisset
            </div>

            <div class="navbar-nav">
                @if(Auth::check())
                    {{-- If user is logged in --}}
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            {{-- Use truename if available, fallback to name --}}
                            <span>{{ Auth::user()->truename ?? Auth::user()->name ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown" style="min-width: 280px; padding: 20px;">
                            <div class="text-center mb-3">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_url)
                                    <img class="img-fluid rounded-circle mb-2" width="64" height="64" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->truename ?? Auth::user()->name }}" />
                                @else
                                    <i class="fas fa-user-circle" style="font-size: 2.5rem; color: #667eea;"></i>
                                @endif
                                <h6 class="mt-2 mb-0">{{ Auth::user()->truename ?? Auth::user()->name ?? 'User' }}</h6>
                                <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                            </div>
                            <hr>
                            <div class="d-grid gap-2"> {{-- Increased gap slightly --}}
                                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary"> {{-- Original used profile.show --}}
                                    <i class="fas fa-user me-1"></i>{{ __('general.dashboard.profile.header') }}
                                </a>
                                <a href="{{ route('app.dashboard') }}" class="btn btn-sm btn-outline-secondary"> {{-- Original dashboard link --}}
                                    <i class="fas fa-tachometer-alt me-1"></i>{{ __('general.menu.dashboard') }}
                                </a>
                                <a href="{{ route('app.donate.history') }}" class="btn btn-sm btn-outline-info"> {{-- Original donate history link --}}
                                    <i class="fas fa-history me-1"></i>{{ __('general.menu.donate.history') }}
                                </a>
                                @if(Auth::user()->isAdministrator())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-user-shield me-1"></i>Admin Dashboard
                                </a>
                                @endif
                                @if(Auth::user()->isGamemaster())
                                <a href="{{ route('gm.dashboard') }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-gamepad me-1"></i>GM Dashboard
                                </a>
                                @endif
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}" class="d-grid">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i>{{ __('general.logout') }}
                                    </a>
                                </form>
                            </div>
                        </ul>
                    </div>
                @else
                    {{-- If user is not logged in --}}
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            <span>Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown" style="min-width: 320px; padding: 20px;">
                            <div class="login-form">
                                <h5 class="text-center mb-3" style="color: #667eea;">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('auth.form.login') }}
                                </h5>

                                {{-- Login form adapted from original navbar --}}
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name-login" class="form-label visually-hidden">{{ __('auth.form.login') }}:</label>
                                        <input id="name-login" type="text" name="name" class="form-control" placeholder="{{ __('auth.form.login_placeholder') ?? 'Username or Email' }}" required autofocus />
                                    </div>

                                    <div class="mb-3">
                                        <label for="password-login" class="form-label visually-hidden">{{ __('auth.form.password') }}:</label>
                                        <input id="password-login" type="password" name="password" class="form-control" placeholder="{{ __('auth.form.password') }}" required />
                                    </div>

                                    @if (! Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                                        <div class="mb-3">
                                            <label for="pin-login" class="form-label visually-hidden">{{ __('auth.form.pin') }}:</label>
                                            <input id="pin-login" type="password" name="pin" class="form-control" placeholder="{{ __('auth.form.pin') }}" required autocomplete="current-pin" />
                                        </div>
                                    @endif

                                    @if( config('pw-config.system.apps.captcha') )
                                        @captcha
                                        <div class="mb-3">
                                            <label for="captcha-login" class="form-label visually-hidden">{{ __('captcha.enter_code') }}:</label>
                                            <input id="captcha-login" type="text" name="captcha" class="form-control" placeholder="{{ __('captcha.enter_code') }}" required />
                                        </div>
                                    @endif

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="remember_me_custom">
                                        <label class="form-check-label" for="remember_me_custom" style="font-size: 14px;">
                                            {{ __('auth.form.remember') }}
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-login w-100 mb-2">
                                        <i class="fas fa-sign-in-alt me-1"></i>{{ __('auth.form.login') }}
                                    </button>
                                </form>

                                <div class="login-divider">────── {{ __('general.or') }} ──────</div>

                                <a href="{{ route('register') }}" class="btn btn-register w-100 mb-2">
                                    <i class="fas fa-user-plus me-1"></i>{{ __('auth.form.register') }}
                                </a>

                                <div class="text-center">
                                    <a href="{{ route('password.request') }}">{{ __('auth.form.forgotPassword') }}</a>
                                </div>
                            </div>
                        </ul>
                    </div>
                @endif
            </div>
        </div> {{-- End .collapse .navbar-collapse --}}

    </div> {{-- End .container-fluid --}}
</nav>

<div class="custom-home-content-wrap"> {{-- Changed from content-wrap --}}
    {{-- Removed banner section from original portal --}}
    <div class="container"> {{-- This container is from home.blade.php --}}
        <div class="main-content-area">
             {{-- Title for category pages, similar to "Latest News" on home --}}
            <h2>
                @if(isset($category_name))
                    {{ ucfirst($category_name) }}
                @elseif(isset($tag_name))
                    Posts tagged with '{{ ucfirst($tag_name) }}'
                @else
                    News
                @endif
            </h2>
            {{ $slotNewsContent }} {{-- This is where the news articles from website.index will go --}}
        </div>
        <aside class="sidebar-area">
            {{ $slotWidgetContent }} {{-- This is where the widget content from website.index will go --}}
        </aside>
    </div>

    <x-hrace009::portal.footer/>
</div>

{{-- Scripts from home.blade.php --}}
<script src="{{ asset('vendor/portal/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/portal/jarallax/dist/jarallax.min.js') }}"></script>

{{-- Initialize Bootstrap 5 tooltips before portal.js --}}
<script>
    // Create jQuery tooltip wrapper for Bootstrap 5 compatibility
    if (typeof bootstrap !== 'undefined' && !$.fn.tooltip) {
        $.fn.tooltip = function(options) {
            return this.each(function() {
                new bootstrap.Tooltip(this, options);
            });
        };
    }
    
    // Also add popover compatibility
    if (typeof bootstrap !== 'undefined' && !$.fn.popover) {
        $.fn.popover = function(options) {
            return this.each(function() {
                new bootstrap.Popover(this, options);
            });
        };
    }
    
    // Only add navbar toggler on mobile screens
    function handleNavbarToggler() {
        const placeholder = document.getElementById('navbar-toggler-placeholder');
        if (!placeholder) return;
        
        if (window.innerWidth < 992) {
            // Only add if not already present
            if (!placeholder.querySelector('.navbar-toggler')) {
                placeholder.innerHTML = '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
            }
        } else {
            // Remove on desktop
            placeholder.innerHTML = '';
        }
    }
    
    // Run on load and resize
    handleNavbarToggler();
    window.addEventListener('resize', handleNavbarToggler);
    
    // Initialize Bootstrap dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    });
</script>

<script src="{{ asset('js/portal/portal.js') }}"></script>

{{-- AlpineJS for dropdowns and other reactive components --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Livewire Scripts --}}
@livewireScripts

</body>
</html>
