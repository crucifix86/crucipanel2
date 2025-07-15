<?php

return [
    // Server Status
    'server' => [
        'online' => 'Server Online',
        'offline' => 'Server Offline',
        'players_online' => ':count Player Online|:count Players Online',
    ],
    
    // Login Box
    'login' => [
        'account' => 'Account',
        'member_login' => 'Member Login',
        'welcome_back' => 'Welcome Back!',
        'username' => 'Username',
        'password' => 'Password',
        'pin' => 'PIN (if required)',
        'login_button' => 'Login',
        'register' => 'Register',
        'forgot_password' => 'Forgot Password?',
        'logout' => 'Logout',
    ],
    
    // User Menu
    'user_menu' => [
        'my_dashboard' => 'My Dashboard',
        'my_profile' => 'My Profile',
        'admin_panel' => 'Admin Panel',
        'gm_panel' => 'GM Panel',
    ],
    
    // Navigation
    'nav' => [
        'home' => 'Home',
        'shop' => 'Shop',
        'donate' => 'Donate',
        'rankings' => 'Rankings',
        'vote' => 'Vote',
        'pages' => 'Pages',
        'members' => 'Members',
    ],
    
    // Language
    'language' => 'Language',
    
    // Visit Reward
    'visit_reward' => [
        'title' => 'Daily Rewards',
        'description' => 'Get rewards for visiting',
        'gold' => 'Gold',
        'bonus_points' => 'Bonus Points',
        'loading' => 'Loading...',
        'check_in' => 'Claim Reward',
        'claimed' => 'Already Claimed',
        'next_reward' => 'Next reward in:',
        'claiming' => 'Claiming...',
        'error' => 'Error',
        'reward_claimed' => 'Reward Claimed!',
    ],
    
    // News Section
    'news' => [
        'title' => 'Latest News & Updates',
        'read_more' => 'Read More',
        'update' => 'Update',
        'event' => 'Event',
        'maintenance' => 'Maintenance',
        'general' => 'General',
        'no_articles' => 'No news articles at the moment',
        'check_back' => 'Check back soon for updates!',
    ],
    
    // Footer
    'footer' => [
        'server_features' => 'Server Features',
        'rates' => [
            'exp' => 'EXP Rate',
            'spirit' => 'SP Rate',
            'drop' => 'Drop Rate',
            'coins' => 'Coins Rate',
        ],
    ],
    
    // Server Features
    'features' => [
        'exp_rate' => [
            'title' => 'EXP Rate',
            'value' => '5x Experience · 3x Spirit',
        ],
        'max_level' => [
            'title' => 'Max Level',
            'value' => 'Level 105 · Rebirth x2',
        ],
        'server_version' => [
            'title' => 'Server Version',
            'value' => 'Perfect World v1.4.6',
        ],
        'pvp_mode' => [
            'title' => 'PvP Mode',
            'value' => 'Balanced PK · Territory Wars',
        ],
    ],
    
    // Shop Page
    'shop' => [
        'title' => 'Mystical Shop',
        'search_placeholder' => 'Search items, vouchers, or services...',
        'search_button' => 'Search',
        'clear' => 'Clear',
        
        // Tabs
        'tabs' => [
            'items' => 'Items',
            'vouchers' => 'Vouchers', 
            'services' => 'Services',
        ],
        
        // User Balance
        'balance' => [
            'coins' => ':name:', // Will be replaced with currency name
            'bonus_points' => 'Bonus Points:',
        ],
        
        // Character Selection
        'character' => [
            'label' => 'Character:',
            'change' => 'Change',
            'no_character' => 'No character selected',
            'select' => 'Select Character',
            'select_to_purchase' => 'Select a character to purchase',
            'select_to_use' => 'Select a character to use service',
            'no_characters' => 'No characters found',
            'server_offline' => 'Server is offline',
        ],
        
        // Categories
        'categories' => [
            'title' => 'Categories',
        ],
        
        // Items
        'items' => [
            'no_items' => 'No Items Available',
            'check_back' => 'Check back later for mystical items!',
            'purchase' => 'Purchase',
            'buy_with_bonus' => 'Buy with :points Bonus Points',
            'original_price' => 'Original Price',
            'discount_badge' => '-:discount%',
        ],
        
        // Vouchers
        'vouchers' => [
            'redeem_title' => 'Redeem Voucher Code',
            'code_placeholder' => 'Enter voucher code',
            'redeem_button' => 'Redeem Code',
            'description' => 'Enter your voucher code above to add :currency to your account',
            'history_button' => 'View Redemption History',
            'history_title' => 'Voucher Redemption History',
            'history_code' => 'Voucher Code',
            'history_amount' => 'Amount',
            'history_date' => 'Redeemed Date',
            'total_redeemed' => 'Total Vouchers Redeemed: :count',
            'login_required' => 'Please login to redeem voucher codes',
        ],
        
        // Services
        'services' => [
            'no_services' => 'No Services Available',
            'check_back' => 'Check back later for character services!',
            'use_button' => 'Use Service',
            'requirements' => 'Requirements',
            'login_required' => 'Login to use services',
        ],
        
        // Pagination
        'pagination' => [
            'previous' => '← Previous',
            'next' => 'Next →',
            'page_of' => 'Page :current of :total',
        ],
        
        // Login Notice
        'login_notice' => 'Please login to access the shop',
        
        // Notifications
        'notifications' => [
            'success' => '✓ :message',
            'error' => '✗ :message',
        ],
    ],
];