<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World - My Dashboard</title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 0;
            position: relative;
        }

        .logo-container {
            position: relative;
            display: inline-block;
        }

        .logo {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 50px rgba(147, 112, 219, 0.8);
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .tagline {
            font-size: 1.2rem;
            color: #b19cd9;
            font-style: italic;
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
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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

        /* Dashboard Content */
        .dashboard-content {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Character Stats Card */
        .character-card {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .character-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .character-name {
            font-size: 2rem;
            color: #9370db;
            font-weight: 700;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .character-level {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .stat-box {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(147, 112, 219, 0.2);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            border-color: #9370db;
            box-shadow: 0 0 20px rgba(147, 112, 219, 0.3);
        }

        .stat-label {
            color: #b19cd9;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #e6d7f0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Account Info Sidebar */
        .account-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .account-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .account-title {
            font-size: 1.3rem;
            color: #9370db;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 600;
        }

        .balance-display {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            text-align: center;
        }

        .balance-label {
            color: #b19cd9;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .balance-amount {
            color: #ffd700;
            font-size: 1.8rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
        }

        .quick-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .quick-link {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 25px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quick-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        /* Characters List */
        .characters-section {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .section-title {
            font-size: 2rem;
            color: #9370db;
            margin-bottom: 25px;
            text-align: center;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .character-item {
            background: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .character-item:hover {
            border-color: #9370db;
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(147, 112, 219, 0.4);
        }

        .character-item.selected {
            border-color: #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }

        .char-name {
            font-size: 1.3rem;
            color: #dda0dd;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .char-info {
            display: flex;
            justify-content: space-between;
            color: #b19cd9;
        }

        .select-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ffd700;
            color: #000;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 700;
            display: none;
        }

        .character-item.selected .select-badge {
            display: block;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 40px 0;
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            margin-top: 60px;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-radius: 20px;
        }

        .footer-text {
            font-size: 1.1rem;
            color: #b19cd9;
            margin-bottom: 20px;
        }

        @media (max-width: 1024px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }
            
            .account-sidebar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .nav-link {
                font-size: 0.95rem;
                padding: 8px 15px;
            }
            
            .characters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <h1 class="logo">Haven Perfect World</h1>
                <p class="tagline">Welcome back, {{ Auth::user()->truename ?? Auth::user()->name }}</p>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-links">
                <a href="{{ route('HOME') }}" class="nav-link">Home</a>
                <a href="{{ route('app.dashboard') }}" class="nav-link active">Dashboard</a>
                
                @if( config('pw-config.system.apps.shop') )
                <a href="{{ route('public.shop') }}" class="nav-link">Shop</a>
                @endif
                
                @if( config('pw-config.system.apps.donate') )
                <a href="{{ route('public.donate') }}" class="nav-link">Donate</a>
                @endif
                
                @if( config('pw-config.system.apps.vote') )
                <a href="{{ route('public.vote') }}" class="nav-link">Vote</a>
                @endif
                
                <a href="{{ route('profile.show') }}" class="nav-link">Profile</a>
                
                @if(Auth::user()->isAdministrator())
                <a href="{{ route('admin.dashboard') }}" class="nav-link" style="background: linear-gradient(45deg, #dc3545, #c82333);">Admin Panel</a>
                @endif
            </div>
        </nav>

        <div class="dashboard-content">
            <div class="main-content">
                @php
                    $api = new \hrace009\PerfectWorldAPI\API();
                    $selectedRole = session('character_id');
                @endphp
                
                @if($selectedRole && $api->online)
                    @php
                        $roleData = $api->getRole($selectedRole);
                        if ($roleData) {
                            $classes = [
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
                                11 => 'Stormbringer'
                            ];
                            $className = $classes[$roleData['base']['cls']] ?? 'Unknown';
                        }
                    @endphp
                    
                    @if($roleData)
                    <div class="character-card">
                        <div class="character-header">
                            <h2 class="character-name">{{ $roleData['base']['name'] }}</h2>
                            <div class="character-level">Level {{ $roleData['status']['level'] }}</div>
                        </div>
                        
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-label">Class</div>
                                <div class="stat-value">{{ $className }}</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">Cultivation</div>
                                <div class="stat-value">{{ $roleData['status']['level2'] }}</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">HP</div>
                                <div class="stat-value">{{ number_format($roleData['status']['hp']) }}</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">MP</div>
                                <div class="stat-value">{{ number_format($roleData['status']['mp']) }}</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">Reputation</div>
                                <div class="stat-value">{{ number_format($roleData['status']['reputation']) }}</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-label">Spirit</div>
                                <div class="stat-value">{{ number_format($roleData['status']['pp']) }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                @else
                    <div class="character-card">
                        <div style="text-align: center; padding: 40px;">
                            <p style="font-size: 1.3rem; color: #b19cd9; margin-bottom: 20px;">
                                @if(!$api->online)
                                    Server is currently offline
                                @else
                                    No character selected
                                @endif
                            </p>
                            <p style="color: #9370db;">Select a character below to view their stats</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="account-sidebar">
                <div class="account-card">
                    <h3 class="account-title">Account Balance</h3>
                    <div class="balance-display">
                        <div class="balance-label">{{ config('pw-config.currency_name', 'Coins') }}</div>
                        <div class="balance-amount">{{ number_format(Auth::user()->money) }}</div>
                    </div>
                    @if(config('pw-config.system.apps.donate'))
                    <div class="balance-display">
                        <div class="balance-label">Bonus Points</div>
                        <div class="balance-amount">{{ number_format(Auth::user()->bonuses) }}</div>
                    </div>
                    @endif
                </div>

                <div class="account-card">
                    <h3 class="account-title">Quick Actions</h3>
                    <div class="quick-links">
                        @if(config('pw-config.system.apps.shop'))
                        <a href="{{ route('public.shop') }}" class="quick-link">Visit Shop</a>
                        @endif
                        @if(config('pw-config.system.apps.vote'))
                        <a href="{{ route('public.vote') }}" class="quick-link">Vote & Earn</a>
                        @endif
                        @if(config('pw-config.system.apps.donate'))
                        <a href="{{ route('public.donate') }}" class="quick-link">Support Server</a>
                        @endif
                        <a href="{{ route('profile.show') }}" class="quick-link">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="characters-section">
            <h2 class="section-title">My Characters</h2>
            <div class="characters-grid">
                @if($api->online)
                    @php
                        $roles = Auth::user()->roles();
                    @endphp
                    
                    @if(count($roles) > 0)
                        @foreach($roles as $role)
                            <div class="character-item {{ session('character_id') == $role['id'] ? 'selected' : '' }}" 
                                 onclick="window.location.href='{{ url('character/select/' . $role['id']) }}'">
                                <div class="select-badge">Selected</div>
                                <div class="char-name">{{ $role['name'] }}</div>
                                <div class="char-info">
                                    <span>Level {{ $role['level'] }}</span>
                                    <span>
                                        @php
                                            $classes = [
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
                                                11 => 'Stormbringer'
                                            ];
                                            echo $classes[$role['cls']] ?? 'Unknown';
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #b19cd9;">
                            No characters found on this account
                        </div>
                    @endif
                @else
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #b19cd9;">
                        Server is offline - Unable to load characters
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p class="footer-text">Your adventure continues...</p>
            <p class="footer-text">&copy; {{ date('Y') }} Haven Perfect World. All rights reserved.</p>
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
    </script>
</body>
</html>