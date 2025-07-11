<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haven Perfect World - Shop</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

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
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 50px rgba(147, 112, 219, 0.8);
            letter-spacing: 3px;
            margin-bottom: 15px;
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

        /* Shop Section */
        .shop-section {
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

        .shop-section::before {
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

        /* Shop Grid */
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 1;
        }

        .shop-item {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
            border: 2px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .shop-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .shop-item:hover::before {
            left: 100%;
        }

        .shop-item:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #9370db;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.4),
                0 0 50px rgba(147, 112, 219, 0.3);
        }

        .item-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: rgba(147, 112, 219, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .item-name {
            font-size: 1.3rem;
            color: #dda0dd;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .item-description {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 20px;
            line-height: 1.4;
            min-height: 40px;
        }

        .item-price {
            font-size: 1.2rem;
            color: #ffd700;
            margin-bottom: 15px;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(45deg, #ff6b6b, #dc3545);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .purchase-button {
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .purchase-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
        }

        .bonus-button {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .bonus-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
        }

        .login-notice {
            text-align: center;
            color: #b19cd9;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        .login-notice a {
            color: #9370db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-notice a:hover {
            color: #dda0dd;
            text-decoration: underline;
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

        @media (max-width: 768px) {
            .logo {
                font-size: 3rem;
            }
            
            .shop-section {
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
        }

        .epic-glow {
            animation: epicGlow 3s ease-in-out infinite alternate;
        }

        @keyframes epicGlow {
            0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
            100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
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
            <div class="mystical-border"></div>
            <div class="logo-container">
                <h1 class="logo">Haven Perfect World</h1>
                <p class="tagline">Mystical Item Shop</p>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-links">
                <a href="{{ route('HOME') }}" class="nav-link">Home</a>
                
                @if( config('pw-config.system.apps.shop') )
                <a href="{{ route('public.shop') }}" class="nav-link active">Shop</a>
                @endif
                
                @if( config('pw-config.system.apps.donate') )
                <a href="{{ route('public.donate') }}" class="nav-link">Donate</a>
                @endif
                
                @if( config('pw-config.system.apps.ranking') )
                <a href="{{ route('public.rankings') }}" class="nav-link">Rankings</a>
                @endif
                
                @if( config('pw-config.system.apps.vote') )
                <a href="{{ route('public.vote') }}" class="nav-link">Vote</a>
                @endif
            </div>
        </nav>

        <div class="shop-section">
            <h2 class="section-title">Item Shop</h2>
            
            <div class="shop-grid">
                @foreach($items as $item)
                    <div class="shop-item">
                        @if($item->discount > 0)
                            <div class="discount-badge">-{{ $item->discount }}%</div>
                        @endif
                        
                        <div class="item-icon">
                            @if($item->mask == 2)
                                👘
                            @elseif($item->mask == 4)
                                👗
                            @elseif($item->mask == 8)
                                🐴
                            @elseif($item->mask == 131072)
                                ⚔️
                            @else
                                📦
                            @endif
                        </div>
                        
                        <h3 class="item-name">{{ $item->name }}</h3>
                        <p class="item-description">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="item-price">
                            @if($item->discount > 0)
                                <div class="original-price" style="text-decoration: line-through; color: #b19cd9; font-size: 0.9rem;">
                                    {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                                </div>
                                {{ number_format($item->price * (1 - $item->discount/100)) }} {{ config('pw-config.currency_name', 'Points') }}
                            @else
                                {{ number_format($item->price) }} {{ config('pw-config.currency_name', 'Points') }}
                            @endif
                        </div>
                        
                        @auth
                            @if(Auth::user()->characterId())
                                <form action="{{ route('app.shop.purchase.post', $item->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    <button type="submit" class="purchase-button">Purchase</button>
                                </form>
                                
                                @if($item->poin > 0)
                                <form action="{{ route('app.shop.point.post', $item->id) }}" method="POST" style="margin-top: 10px;">
                                    @csrf
                                    <button type="submit" class="bonus-button">Buy with {{ $item->poin }} Bonus Points</button>
                                </form>
                                @endif
                            @else
                                <p style="color: #b19cd9; font-size: 0.9rem; margin-top: 15px;">Select a character to purchase</p>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
            
            @guest
            <div class="login-notice">
                <p>Please <a href="{{ route('login') }}">login</a> to purchase items</p>
            </div>
            @else
            <div class="login-notice" style="color: #9370db;">
                <p>Welcome {{ Auth::user()->truename ?? Auth::user()->name }}! Browse our mystical items.</p>
            </div>
            @endguest
        </div>

        <div class="footer">
            <p class="footer-text">Enhance your journey with mystical items</p>
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