@section('title', ' - ' . __('general.menu.dashboard'))
<x-hrace009.layouts.app-mystical>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-purple-300 text-center">{{ __('general.menu.dashboard') }}</h1>
    </x-slot>

    <x-slot name="content">
        <div class="space-y-6">
            <style>
                /* News Card Styling */
                .news-card {
                    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
                    border: 2px solid rgba(147, 112, 219, 0.4);
                    border-radius: 20px;
                    padding: 30px;
                    margin-bottom: 20px;
                    transition: all 0.4s ease;
                    position: relative;
                    overflow: hidden;
                    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
                }

                .news-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
                    transition: left 0.5s ease;
                }

                .news-card:hover::before {
                    left: 100%;
                }

                .news-card:hover {
                    transform: translateY(-5px);
                    border-color: #9370db;
                    box-shadow: 
                        0 25px 60px rgba(0, 0, 0, 0.4),
                        0 0 50px rgba(147, 112, 219, 0.3);
                }

                .news-icon {
                    font-size: 3rem;
                    margin-bottom: 20px;
                    display: block;
                    text-align: center;
                    animation: iconFloat 3s ease-in-out infinite;
                }

                @keyframes iconFloat {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-10px); }
                }

                .news-title {
                    font-size: 1.8rem;
                    color: #9370db;
                    margin-bottom: 15px;
                    text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
                    font-weight: 600;
                }

                .news-title a {
                    color: inherit;
                    text-decoration: none;
                    transition: all 0.3s ease;
                }

                .news-title a:hover {
                    color: #dda0dd;
                }

                .news-meta {
                    font-size: 0.9rem;
                    color: #b19cd9;
                    margin-bottom: 20px;
                    display: flex;
                    align-items: center;
                    gap: 15px;
                }

                .news-category {
                    background: linear-gradient(45deg, #9370db, #8a2be2);
                    color: #fff;
                    padding: 4px 12px;
                    border-radius: 15px;
                    font-size: 0.8rem;
                    font-weight: 600;
                    text-transform: uppercase;
                }

                .news-description {
                    color: #b19cd9;
                    line-height: 1.6;
                    margin-bottom: 25px;
                    font-size: 1rem;
                }

                .read-more-btn {
                    background: linear-gradient(45deg, #9370db, #8a2be2, #4b0082);
                    background-size: 300% 300%;
                    color: #fff;
                    border: none;
                    padding: 12px 30px;
                    font-size: 1rem;
                    font-weight: 600;
                    border-radius: 30px;
                    cursor: pointer;
                    transition: all 0.4s ease;
                    text-decoration: none;
                    display: inline-block;
                    animation: buttonGlow 2s ease-in-out infinite alternate;
                }

                @keyframes buttonGlow {
                    0% { 
                        box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
                        background-position: 0% 50%;
                    }
                    100% { 
                        box-shadow: 0 8px 30px rgba(138, 43, 226, 0.6);
                        background-position: 100% 50%;
                    }
                }

                .read-more-btn:hover {
                    transform: scale(1.05);
                    box-shadow: 0 15px 40px rgba(147, 112, 219, 0.8);
                }

                /* Welcome Section */
                .welcome-section {
                    background: linear-gradient(135deg, rgba(147, 112, 219, 0.2), rgba(75, 0, 130, 0.2));
                    backdrop-filter: blur(20px);
                    border: 2px solid rgba(147, 112, 219, 0.4);
                    border-radius: 30px;
                    padding: 40px;
                    margin-bottom: 40px;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }

                .welcome-section::before {
                    content: '';
                    position: absolute;
                    top: -50%;
                    left: -50%;
                    width: 200%;
                    height: 200%;
                    background: linear-gradient(45deg, transparent, rgba(147, 112, 219, 0.1), transparent);
                    animation: shimmer 4s infinite;
                }

                .welcome-title {
                    font-size: 2.5rem;
                    color: #9370db;
                    margin-bottom: 15px;
                    text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
                    animation: epicGlow 3s ease-in-out infinite alternate;
                }

                @keyframes epicGlow {
                    0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
                    100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
                }

                .welcome-subtitle {
                    font-size: 1.3rem;
                    color: #b19cd9;
                    font-style: italic;
                }

                /* Empty State */
                .empty-state {
                    text-align: center;
                    padding: 60px 20px;
                    color: #b19cd9;
                }

                .empty-state-icon {
                    font-size: 5rem;
                    margin-bottom: 20px;
                    animation: pulse 2s ease-in-out infinite;
                }

                @keyframes pulse {
                    0%, 100% { transform: scale(1); opacity: 0.8; }
                    50% { transform: scale(1.1); opacity: 1; }
                }

                .empty-state-text {
                    font-size: 1.5rem;
                    margin-bottom: 10px;
                }

                .empty-state-subtext {
                    font-size: 1.1rem;
                    color: #8a6bb3;
                }
            </style>

            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2 class="welcome-title">
                    {{ __('general.welcome') }}, {{ Auth::user()->truename ?? Auth::user()->name }}!
                </h2>
                <p class="welcome-subtitle">
                    {{ __('general.welcome_message') }}
                </p>
            </div>

            <!-- News Section -->
            <div class="news-section">
                <x-hrace009::front.news-view/>
            </div>
        </div>
    </x-slot>
</x-hrace009.layouts.app-mystical>