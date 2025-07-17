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
    
    // Donate Page
    'donate' => [
        'title' => 'Dukung Haven Perfect World',
        'subtitle' => 'Donasi Anda membantu menjaga server tetap berjalan dan meningkatkan pengalaman bermain untuk semua orang',
        
        // Payment Methods
        'methods' => [
            'paypal' => [
                'name' => 'PayPal',
                'description' => 'Pemrosesan pembayaran cepat dan aman dengan pengiriman :currency instan',
                'button' => 'Donasi via PayPal',
            ],
            'bank' => [
                'name' => 'Transfer Bank',
                'description' => 'Transfer bank langsung dengan verifikasi manual (1-2 hari kerja)',
                'button' => 'Donasi via Bank',
                'available_banks' => 'Bank Tersedia:',
            ],
            'paymentwall' => [
                'name' => 'Paymentwall',
                'description' => 'Berbagai pilihan pembayaran termasuk kartu mobile dan prabayar',
                'button' => 'Donasi via Paymentwall',
            ],
            'ipaymu' => [
                'name' => 'iPaymu',
                'description' => 'Gateway pembayaran Indonesia dengan dukungan bank lokal',
                'button' => 'Donasi via iPaymu',
            ],
            'login_required' => 'Login Diperlukan',
            'no_methods' => 'Tidak Ada Metode Pembayaran Dikonfigurasi',
            'contact_admin' => 'Silakan hubungi administrator untuk mengaktifkan metode donasi.',
        ],
        
        // Payment Details
        'details' => [
            'rate' => 'Kurs:',
            'minimum' => 'Minimum:',
            'bonus' => '🎉 Bonus:',
            'double_active' => 'Double :currency Aktif!',
        ],
        
        // Benefits Section
        'benefits' => [
            'title' => 'Manfaat Donasi',
            'points' => ':currency Poin',
            'rewards' => 'Hadiah Bonus',
            'instant' => 'Pengiriman Instan',
            'secure' => 'Pembayaran Aman',
        ],
        
        // Login Notice
        'login_notice' => 'Silakan login untuk melakukan donasi',
        'welcome_donor' => 'Selamat datang :name! Terima kasih telah mendukung realm kami.',
    ],
    
    // Rankings Page
    'rankings' => [
        'title' => 'Peringkat',
        'top_players' => 'Pemain Teratas',
        'top_factions' => 'Faksi Teratas',
        'pvp_champions' => 'Juara PvP',
        'no_players' => 'Tidak ada pemain ditemukan. Silakan perbarui peringkat di panel admin.',
        'level' => 'Lv.',
        'members' => 'Anggota:',
        'kills' => 'Bunuh',
        'forgot' => 'Lupa?',
        
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
            'unknown' => 'Tidak Diketahui',
        ],
    ],
    
    // Vote Page
    'vote' => [
        'title' => 'Vote',
        'main_title' => 'Vote untuk Haven Perfect World',
        'subtitle' => 'Dukung server kami dan dapatkan hadiah dengan voting di situs-situs ini',
        'balance_info' => 'Vote untuk mendapatkan hadiah dan melihat saldo Anda meningkat!',
        'test_mode_active' => 'MODE TES ARENA AKTIF',
        'test_mode_info' => [
            'callbacks' => 'Callback akan selalu mengembalikan vote berhasil',
            'cooldown' => 'Timer cooldown vote dinonaktifkan',
            'reminder' => 'Ingat untuk menonaktifkan mode tes di produksi!',
        ],
        
        // Arena Section
        'arena' => [
            'title' => 'Arena Top 100',
            'gold' => 'Emas',
            'description' => 'Vote setiap :hours jam di Arena Top 100',
            'button' => 'Vote di Arena Top 100',
            'claim_button' => 'Klaim Hadiah',
            'only_title' => 'Hanya Arena Top 100',
            'only_description' => 'Kami menggunakan sistem voting terverifikasi Arena Top 100 untuk memastikan hadiah yang adil!',
            'vote_confirmed' => 'Vote Arena Top 100 Dikonfirmasi!',
            'reward_added' => ':amount :type telah ditambahkan ke akun Anda!',
            'confirmed_message' => 'Arena Top 100 mengkonfirmasi vote Anda! +:amount :type ditambahkan!',
            'opening_message' => 'Membuka halaman voting Arena Top 100. Selesaikan vote Anda dan hadiah akan otomatis diterapkan saat Arena mengkonfirmasi vote Anda!',
            'only_supported' => 'Hanya voting Arena Top 100 yang didukung.',
        ],
        
        // Cooldown
        'cooldown' => [
            'please_wait' => 'Harap tunggu:',
        ],
        
        // Why Vote Section
        'why_vote' => [
            'title' => 'Mengapa Vote?',
            'earn_currency' => 'Dapatkan Mata Uang',
            'help_grow' => 'Bantu Server Berkembang',
            'daily_rewards' => 'Hadiah Harian',
            'top_prizes' => 'Hadiah Voter Teratas',
        ],
        
        // Login Notice
        'login_notice' => 'Silakan login untuk vote dan menerima hadiah',
        'welcome_voter' => 'Selamat datang :name! Vote untuk mendukung server kami dan dapatkan hadiah.',
        
        // JavaScript Messages
        'js' => [
            'vote_confirmed' => 'Vote dikonfirmasi! +:amount :type ditambahkan!',
            'error_checking' => 'Error memeriksa status vote:',
        ],
    ],
    
    // Members Page
    'members' => [
        'title' => 'Anggota',
        'community_members' => 'Anggota Komunitas',
        'staff_members' => 'Anggota Staf',
        'administrator' => 'Administrator',
        'game_master' => 'Game Master',
        'member_since' => 'Anggota sejak :date',
        'characters' => ':count Karakter',
        'online' => 'Online',
        'unknown' => 'Tidak Diketahui',
        'registered_players' => 'Pemain Terdaftar (:count)',
        'search_placeholder' => 'Cari berdasarkan username atau karakter...',
        'search_button' => 'Cari',
        'clear' => 'Hapus',
        'table' => [
            'player' => 'Pemain',
            'characters' => 'Karakter',
            'member_since' => 'Anggota Sejak',
            'discord' => 'Discord',
        ],
        'no_characters' => 'Tidak ada karakter',
        'not_shared' => 'Tidak dibagikan',
        'no_players' => 'Belum ada pemain terdaftar. Jadilah yang pertama untuk bergabung!',
        'pagination' => [
            'previous' => '← Sebelumnya',
            'next' => 'Berikutnya →',
            'page_of' => 'Halaman :current dari :total',
        ],
        'forgot' => 'Lupa?',
    ],
    
    // Profile Page
    'profile' => [
        'title' => 'Profil',
        'page_title' => 'Akun Saya',
        'page_subtitle' => 'Kelola pengaturan dan preferensi profil Anda',
        'success_message' => 'Pengaturan berhasil disimpan! Memuat ulang halaman...',
        
        // Sidebar
        'sidebar' => [
            'member_since' => 'Anggota Sejak',
            'account_status' => 'Status Akun',
            'status_active' => 'Aktif',
            'last_login' => 'Login Terakhir',
        ],
        
        // Sections
        'sections' => [
            'profile_info' => [
                'title' => 'Informasi Profil',
                'description' => 'Perbarui informasi profil dan alamat email akun Anda',
            ],
            'language' => [
                'title' => 'Preferensi Bahasa',
                'description' => 'Pilih bahasa yang Anda inginkan untuk antarmuka',
            ],
            'theme' => [
                'title' => 'Preferensi Tema',
                'description' => 'Pilih tema yang Anda inginkan untuk website',
                'select_theme' => 'Pilih Tema',
                'default_theme' => 'Gunakan Tema Default',
                'save_button' => 'Simpan Tema',
            ],
            'password' => [
                'title' => 'Perbarui Kata Sandi',
                'description' => 'Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman',
            ],
            'pin' => [
                'title' => 'Pengaturan PIN',
                'description' => 'Kelola PIN akun Anda untuk keamanan tambahan',
            ],
            'sessions' => [
                'title' => 'Sesi Browser',
                'description' => 'Kelola dan keluar dari sesi aktif Anda di browser dan perangkat lain',
            ],
            'delete_account' => [
                'title' => 'Hapus Akun',
                'description' => 'Hapus akun Anda secara permanen',
            ],
            'characters' => [
                'title' => 'Karakter Saya',
                'description' => 'Lihat dan kelola karakter dalam game Anda',
            ],
        ],
    ],
];