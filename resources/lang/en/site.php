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
    
    // Donate Page
    'donate' => [
        'title' => 'Support Haven Perfect World',
        'subtitle' => 'Your donations help keep the server running and improve the gaming experience for everyone',
        
        // Payment Methods
        'methods' => [
            'paypal' => [
                'name' => 'PayPal',
                'description' => 'Fast and secure payment processing with instant :currency delivery',
                'button' => 'Donate via PayPal',
            ],
            'bank' => [
                'name' => 'Bank Transfer',
                'description' => 'Direct bank transfer with manual verification (1-2 business days)',
                'button' => 'Donate via Bank',
                'available_banks' => 'Available Banks:',
            ],
            'paymentwall' => [
                'name' => 'Paymentwall',
                'description' => 'Multiple payment options including mobile and prepaid cards',
                'button' => 'Donate via Paymentwall',
            ],
            'ipaymu' => [
                'name' => 'iPaymu',
                'description' => 'Indonesian payment gateway with local bank support',
                'button' => 'Donate via iPaymu',
            ],
            'login_required' => 'Login Required',
            'no_methods' => 'No Payment Methods Configured',
            'contact_admin' => 'Please contact an administrator to enable donation methods.',
        ],
        
        // Payment Details
        'details' => [
            'rate' => 'Rate:',
            'minimum' => 'Minimum:',
            'bonus' => '🎉 Bonus:',
            'double_active' => 'Double :currency Active!',
        ],
        
        // Benefits Section
        'benefits' => [
            'title' => 'Donation Benefits',
            'points' => ':currency Points',
            'rewards' => 'Bonus Rewards',
            'instant' => 'Instant Delivery',
            'secure' => 'Secure Payment',
        ],
        
        // Login Notice
        'login_notice' => 'Please login to make a donation',
        'welcome_donor' => 'Welcome :name! Thank you for supporting our realm.',
    ],
    
    // Rankings Page
    'rankings' => [
        'title' => 'Rankings',
        'top_players' => 'Top Players',
        'top_factions' => 'Top Factions',
        'pvp_champions' => 'PvP Champions',
        'no_players' => 'No players found. Please update rankings in admin panel.',
        'level' => 'Lv.',
        'members' => 'Members:',
        'kills' => 'Kills',
        'forgot' => 'Forgot?',
        
        // Classes
        'classes' => [
            0 => 'Blademaster',
            1 => 'Wizard',
            2 => 'Psychic',
            3 => 'Venomancer',
            4 => 'Barbarian',
            5 => 'Assassin',
            6 => 'Archer',
            7 => 'Cleric',
            8 => 'Seeker',
            9 => 'Mystic',
            10 => 'Duskblade',
            11 => 'Stormbringer',
            'unknown' => 'Unknown',
        ],
    ],
    
    // Vote Page
    'vote' => [
        'title' => 'Vote',
        'main_title' => 'Vote for Haven Perfect World',
        'subtitle' => 'Support our server and earn rewards by voting on these sites',
        'balance_info' => 'Vote to earn rewards and see your balance increase!',
        'test_mode_active' => 'ARENA TEST MODE ACTIVE',
        'test_mode_info' => [
            'callbacks' => 'Callbacks will always return successful vote',
            'cooldown' => 'Vote cooldown timer is disabled',
            'reminder' => 'Remember to disable test mode in production!',
        ],
        
        // Arena Section
        'arena' => [
            'title' => 'Arena Top 100',
            'gold' => 'Gold',
            'description' => 'Vote every :hours hours on Arena Top 100',
            'button' => 'Vote on Arena Top 100',
            'claim_button' => 'Claim Rewards',
            'only_title' => 'Arena Top 100 Only',
            'only_description' => 'We use Arena Top 100\'s verified voting system to ensure fair rewards!',
            'vote_confirmed' => 'Arena Top 100 Vote Confirmed!',
            'reward_added' => ':amount :type has been added to your account!',
            'confirmed_message' => 'Arena Top 100 confirmed your vote! +:amount :type added!',
            'opening_message' => 'Opening Arena Top 100 voting page. Complete your vote and your rewards will be automatically applied when Arena confirms your vote!',
            'only_supported' => 'Only Arena Top 100 voting is supported.',
        ],
        
        // Cooldown
        'cooldown' => [
            'please_wait' => 'Please wait:',
        ],
        
        // Why Vote Section
        'why_vote' => [
            'title' => 'Why Vote?',
            'earn_currency' => 'Earn Currency',
            'help_grow' => 'Help Server Grow',
            'daily_rewards' => 'Daily Rewards',
            'top_prizes' => 'Top Voter Prizes',
        ],
        
        // Login Notice
        'login_notice' => 'Please login to vote and receive rewards',
        'welcome_voter' => 'Welcome :name! Vote to support our server and earn rewards.',
        
        // JavaScript Messages
        'js' => [
            'vote_confirmed' => 'Vote confirmed! +:amount :type added!',
            'error_checking' => 'Error checking vote status:',
        ],
    ],
    
    // Members Page
    'members' => [
        'title' => 'Members',
        'community_members' => 'Community Members',
        'staff_members' => 'Staff Members',
        'administrator' => 'Administrator',
        'game_master' => 'Game Master',
        'member_since' => 'Member since :date',
        'characters' => ':count Characters',
        'online' => 'Online',
        'unknown' => 'Unknown',
        'registered_players' => 'Registered Players (:count)',
        'search_placeholder' => 'Search by username or character...',
        'search_button' => 'Search',
        'clear' => 'Clear',
        'table' => [
            'player' => 'Player',
            'characters' => 'Characters',
            'member_since' => 'Member Since',
            'discord' => 'Discord',
        ],
        'no_characters' => 'No characters',
        'not_shared' => 'Not shared',
        'no_players' => 'No registered players yet. Be the first to join!',
        'pagination' => [
            'previous' => '← Previous',
            'next' => 'Next →',
            'page_of' => 'Page :current of :total',
        ],
        'forgot' => 'Forgot?',
    ],
    
    // Profile Page
    'profile' => [
        'title' => 'Profile',
        'page_title' => 'My Account',
        'page_subtitle' => 'Manage your profile settings and preferences',
        'success_message' => 'Settings saved successfully! Refreshing page...',
        
        // Sidebar
        'sidebar' => [
            'member_since' => 'Member Since',
            'account_status' => 'Account Status',
            'status_active' => 'Active',
            'last_login' => 'Last Login',
        ],
        
        // Sections
        'sections' => [
            'profile_info' => [
                'title' => 'Profile Information',
                'description' => 'Update your account\'s profile information and email address',
            ],
            'language' => [
                'title' => 'Language Preference',
                'description' => 'Choose your preferred language for the interface',
            ],
            'theme' => [
                'title' => 'Theme Preference',
                'description' => 'Choose your preferred theme for the website',
            ],
            'password' => [
                'title' => 'Update Password',
                'description' => 'Ensure your account is using a long, random password to stay secure',
            ],
            'pin' => [
                'title' => 'PIN Settings',
                'description' => 'Manage your account PIN for additional security',
            ],
            'sessions' => [
                'title' => 'Browser Sessions',
                'description' => 'Manage and log out your active sessions on other browsers and devices',
            ],
            'delete_account' => [
                'title' => 'Delete Account',
                'description' => 'Permanently delete your account',
            ],
            'characters' => [
                'title' => 'My Characters',
                'description' => 'View and manage your in-game characters',
            ],
        ],
    ],
];