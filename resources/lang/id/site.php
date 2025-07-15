<?php

return [
    // Server Status
    'server' => [
        'online' => 'Server Online',
        'offline' => 'Server Offline',
        'players_online' => ':count Pemain Online|:count Pemain Online',
    ],
    
    // Login Box
    'login' => [
        'account' => 'Akun',
        'member_login' => 'Login Anggota',
        'welcome_back' => 'Selamat Datang Kembali!',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'pin' => 'PIN (jika diperlukan)',
        'login_button' => 'Masuk',
        'register' => 'Daftar',
        'forgot_password' => 'Lupa Kata Sandi?',
        'logout' => 'Keluar',
    ],
    
    // User Menu
    'user_menu' => [
        'my_dashboard' => 'Dasbor Saya',
        'my_profile' => 'Profil Saya',
        'admin_panel' => 'Panel Admin',
        'gm_panel' => 'Panel GM',
    ],
    
    // Navigation
    'nav' => [
        'home' => 'Beranda',
        'shop' => 'Toko',
        'donate' => 'Donasi',
        'rankings' => 'Peringkat',
        'vote' => 'Vote',
        'pages' => 'Halaman',
        'members' => 'Anggota',
    ],
    
    // Language
    'language' => 'Bahasa',
    
    // Visit Reward
    'visit_reward' => [
        'title' => 'Hadiah Harian',
        'description' => 'Dapatkan hadiah untuk kunjungan',
        'gold' => 'Emas',
        'bonus_points' => 'Poin Bonus',
        'loading' => 'Memuat...',
        'check_in' => 'Klaim Hadiah',
        'claimed' => 'Sudah Diklaim',
        'next_reward' => 'Hadiah berikutnya dalam:',
        'claiming' => 'Mengklaim...',
        'error' => 'Error',
        'reward_claimed' => 'Hadiah Diklaim!',
    ],
    
    // News Section
    'news' => [
        'title' => 'Berita & Pembaruan Terbaru',
        'read_more' => 'Baca Selengkapnya',
        'update' => 'Pembaruan',
        'event' => 'Event',
        'maintenance' => 'Pemeliharaan',
        'general' => 'Umum',
        'no_articles' => 'Tidak ada artikel berita saat ini',
        'check_back' => 'Kembali lagi nanti untuk pembaruan!',
    ],
    
    // Footer
    'footer' => [
        'server_features' => 'Fitur Server',
        'rates' => [
            'exp' => 'Rate EXP',
            'spirit' => 'Rate SP',
            'drop' => 'Rate Drop',
            'coins' => 'Rate Koin',
        ],
    ],
    
    // Server Features
    'features' => [
        'exp_rate' => [
            'title' => 'Rate EXP',
            'value' => '5x Pengalaman · 3x Spirit',
        ],
        'max_level' => [
            'title' => 'Level Maksimal',
            'value' => 'Level 105 · Kelahiran Kembali x2',
        ],
        'server_version' => [
            'title' => 'Versi Server',
            'value' => 'Perfect World v1.4.6',
        ],
        'pvp_mode' => [
            'title' => 'Mode PvP',
            'value' => 'PK Seimbang · Perang Wilayah',
        ],
    ],
    
    // Shop Page
    'shop' => [
        'title' => 'Toko Mistik',
        'search_placeholder' => 'Cari item, voucher, atau layanan...',
        'search_button' => 'Cari',
        'clear' => 'Hapus',
        
        // Tabs
        'tabs' => [
            'items' => 'Item',
            'vouchers' => 'Voucher', 
            'services' => 'Layanan',
        ],
        
        // User Balance
        'balance' => [
            'coins' => ':name:', // Will be replaced with currency name
            'bonus_points' => 'Poin Bonus:',
        ],
        
        // Character Selection
        'character' => [
            'label' => 'Karakter:',
            'change' => 'Ganti',
            'no_character' => 'Tidak ada karakter terpilih',
            'select' => 'Pilih Karakter',
            'select_to_purchase' => 'Pilih karakter untuk membeli',
            'select_to_use' => 'Pilih karakter untuk menggunakan layanan',
            'no_characters' => 'Tidak ada karakter ditemukan',
            'server_offline' => 'Server sedang offline',
        ],
        
        // Categories
        'categories' => [
            'title' => 'Kategori',
        ],
        
        // Items
        'items' => [
            'no_items' => 'Tidak Ada Item Tersedia',
            'check_back' => 'Periksa kembali nanti untuk item mistik!',
            'purchase' => 'Beli',
            'buy_with_bonus' => 'Beli dengan :points Poin Bonus',
            'original_price' => 'Harga Asli',
            'discount_badge' => '-:discount%',
        ],
        
        // Vouchers
        'vouchers' => [
            'redeem_title' => 'Tukar Kode Voucher',
            'code_placeholder' => 'Masukkan kode voucher',
            'redeem_button' => 'Tukar Kode',
            'description' => 'Masukkan kode voucher di atas untuk menambah :currency ke akun Anda',
            'history_button' => 'Lihat Riwayat Penukaran',
            'history_title' => 'Riwayat Penukaran Voucher',
            'history_code' => 'Kode Voucher',
            'history_amount' => 'Jumlah',
            'history_date' => 'Tanggal Ditukar',
            'total_redeemed' => 'Total Voucher Ditukar: :count',
            'login_required' => 'Silakan masuk untuk menukar kode voucher',
        ],
        
        // Services
        'services' => [
            'no_services' => 'Tidak Ada Layanan Tersedia',
            'check_back' => 'Periksa kembali nanti untuk layanan karakter!',
            'use_button' => 'Gunakan Layanan',
            'requirements' => 'Persyaratan',
            'login_required' => 'Masuk untuk menggunakan layanan',
        ],
        
        // Pagination
        'pagination' => [
            'previous' => '← Sebelumnya',
            'next' => 'Berikutnya →',
            'page_of' => 'Halaman :current dari :total',
        ],
        
        // Login Notice
        'login_notice' => 'Silakan masuk untuk mengakses toko',
        
        // Notifications
        'notifications' => [
            'success' => '✓ :message',
            'error' => '✗ :message',
        ],
    ],
];