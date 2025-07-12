<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - {{ config('pw-config.server_name', 'Haven Perfect World') }}</title>
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
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-bar {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(147, 112, 219, 0.3);
            padding: 20px 40px;
            position: relative;
            z-index: 100;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #b19cd9;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link:hover {
            color: #e6d7f0;
            background: rgba(147, 112, 219, 0.2);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #9370db;
            background: rgba(147, 112, 219, 0.3);
            box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
        }

        /* Dropdown Styles */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dropdown-arrow {
            font-size: 0.8rem;
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
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.9), rgba(147, 112, 219, 0.2));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            padding: 10px 0;
            min-width: 200px;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.3s ease;
            margin-top: 10px;
            z-index: 1000;
        }

        .nav-dropdown.active .dropdown-menu {
            max-height: 400px;
            opacity: 1;
        }

        .dropdown-item {
            display: block;
            padding: 10px 20px;
            color: #b19cd9;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .dropdown-item:hover {
            background: rgba(147, 112, 219, 0.2);
            color: #e6d7f0;
        }

        .content-section {
            padding: 50px 0;
        }

        .page-title {
            text-align: center;
            font-size: 3rem;
            color: #9370db;
            margin-bottom: 50px;
            text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
        }

        .members-section {
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2rem;
            color: #b19cd9;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .members-list {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border: 1px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 50px;
        }
        
        .members-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .members-table th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid rgba(147, 112, 219, 0.3);
            color: #b19cd9;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .members-table td {
            padding: 15px 10px;
            border-bottom: 1px solid rgba(147, 112, 219, 0.1);
            color: #e6d7f0;
        }
        
        .members-table tr:hover {
            background: rgba(147, 112, 219, 0.1);
        }
        
        .member-list-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
            border: 2px solid rgba(147, 112, 219, 0.3);
        }
        
        .member-list-name {
            font-weight: 600;
            color: #e6d7f0;
        }
        
        .discord-list-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #7289da;
            font-size: 0.9rem;
        }
        
        .no-discord-list {
            color: #666;
            font-style: italic;
            font-size: 0.85rem;
        }

        .member-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(147, 112, 219, 0.4);
            border-color: #9370db;
        }

        .member-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 15px;
            border: 3px solid #9370db;
            box-shadow: 0 0 20px rgba(147, 112, 219, 0.6);
        }

        .member-name {
            font-size: 1.3rem;
            color: #e6d7f0;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .member-role {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .role-admin {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.4);
        }

        .role-gm {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }

        .role-member {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: white;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.4);
        }

        .member-info {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 5px;
        }

        .discord-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #7289da;
            font-size: 0.95rem;
            margin-top: 10px;
        }

        .discord-icon {
            width: 20px;
            height: 20px;
        }

        .no-discord {
            color: #666;
            font-style: italic;
            font-size: 0.85rem;
        }

        .footer {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
            border-top: 2px solid rgba(147, 112, 219, 0.3);
            padding: 30px 40px;
            text-align: center;
            color: #b19cd9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .members-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .nav-link {
                font-size: 1rem;
                padding: 8px 15px;
            }
            
            .members-list {
                padding: 20px;
                overflow-x: auto;
            }
            
            .members-table {
                min-width: 500px;
            }
            
            .members-table th,
            .members-table td {
                padding: 10px 5px;
                font-size: 0.9rem;
            }
            
            .member-list-avatar {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="mystical-bg"></div>
    <div class="floating-particles"></div>
    
    <div class="dragon-ornament dragon-left">🐉</div>
    <div class="dragon-ornament dragon-right">🐉</div>
    
    <nav class="nav-bar">
        <div class="nav-links">
            <a href="{{ route('HOME') }}" class="nav-link">Home</a>
            <a href="{{ route('public.shop') }}" class="nav-link">Shop</a>
            <a href="{{ route('public.donate') }}" class="nav-link">Donate</a>
            <a href="{{ route('public.rankings') }}" class="nav-link">Rankings</a>
            <a href="{{ route('public.vote') }}" class="nav-link">Vote</a>
            
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
            
            <a href="{{ route('public.members') }}" class="nav-link active">Members</a>
        </div>
    </nav>
    
    <div class="container content-section">
        <h1 class="page-title">Community Members</h1>
        
        @if(count($gms) > 0)
        <div class="members-section">
            <h2 class="section-title">Staff Members</h2>
            <div class="members-grid">
                @foreach($gms as $gm)
                <div class="member-card">
                    <img src="{{ $gm->profile_photo_url }}" alt="{{ $gm->truename ?? $gm->name }}" class="member-avatar">
                    <h3 class="member-name">{{ $gm->truename ?? $gm->name }}</h3>
                    <span class="member-role {{ $gm->isAdministrator() ? 'role-admin' : 'role-gm' }}">
                        {{ $gm->isAdministrator() ? 'Administrator' : 'Game Master' }}
                    </span>
                    <div class="member-info">
                        Member since {{ $gm->created_at->format('M Y') }}
                    </div>
                    @if($gm->discord_id)
                        <div class="discord-info">
                            <svg class="discord-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                            </svg>
                            {{ $gm->discord_id }}
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="members-section">
            <h2 class="section-title">Registered Players ({{ $totalMembers ?? count($members) }})</h2>
            <div class="members-list">
                @if(count($members) > 0)
                    <table class="members-table">
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Member Since</th>
                                <th>Discord</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>
                                    <img src="{{ $member->profile_photo_url }}" alt="{{ $member->truename ?? $member->name }}" class="member-list-avatar">
                                    <span class="member-list-name">{{ $member->truename ?? $member->name }}</span>
                                </td>
                                <td>{{ $member->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($member->discord_id)
                                        <div class="discord-list-info">
                                            <svg class="discord-icon" style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                                            </svg>
                                            {{ $member->discord_id }}
                                        </div>
                                    @else
                                        <span class="no-discord-list">Not shared</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; color: #b19cd9; padding: 40px;">
                        No registered players yet. Be the first to join!
                    </div>
                @endif
                
                @if(isset($totalPages) && $totalPages > 1)
                    <div style="text-align: center; margin-top: 30px;">
                        @if($page > 1)
                            <a href="?page={{ $page - 1 }}" style="color: #9370db; text-decoration: none; margin: 0 10px;">← Previous</a>
                        @endif
                        
                        <span style="color: #b19cd9; margin: 0 15px;">Page {{ $page }} of {{ $totalPages }}</span>
                        
                        @if($page < $totalPages)
                            <a href="?page={{ $page + 1 }}" style="color: #9370db; text-decoration: none; margin: 0 10px;">Next →</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
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
    </script>
</body>
</html>