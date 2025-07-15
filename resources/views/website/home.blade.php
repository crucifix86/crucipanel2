@extends('layouts.mystical')

@section('title', 'Haven Perfect World')

@section('content')
<!-- Main Content Section -->
<div class="content-section">
    <h2 class="section-title">{{ __('site.news.title') }}</h2>
    <div class="news-grid">
        @if( isset($news) && $news->items() )
            @foreach( $news as $article )
                <div class="news-card">
                    <span class="news-icon">
                        @if($article->category == 'update')
                            ✨
                        @elseif($article->category == 'event')
                            🎆
                        @elseif($article->category == 'maintenance')
                            🔧
                        @else
                            📜
                        @endif
                    </span>
                    <h3 class="news-title"><a href="javascript:void(0)" onclick="openNewsPopup('{{ $article->slug }}')">{{ $article->title }}</a></h3>
                    <div class="news-meta">
                        <span class="news-date">📅 {{ $article->date( $article->created_at ) }}</span>
                        <span class="news-category">{{ __('news.category.' . $article->category) }}</span>
                    </div>
                    <p class="news-description">{{ Str::limit($article->description, 150) }}</p>
                    <a href="javascript:void(0)" onclick="openNewsPopup('{{ $article->slug }}')" class="read-more-btn">{{ __('site.news.read_more') }}</a>
                </div>
            @endforeach
        @else
            <div style="text-align: center; color: #b19cd9;">
                <p>📜 {{ __('site.news.no_articles') }}</p>
                <p>{{ __('site.news.check_back') }}</p>
            </div>
        @endif
    </div>
</div>

<div class="server-features">
    <div class="feature-card">
        <div class="feature-icon">🌟</div>
        <div class="feature-title">{{ __('site.footer.rates.exp') }}</div>
        <div class="feature-value">{{ __('site.features.exp_rate.value') }}</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">⚖️</div>
        <div class="feature-title">{{ __('site.features.max_level.title') }}</div>
        <div class="feature-value">{{ __('site.features.max_level.value') }}</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🏛️</div>
        <div class="feature-title">{{ __('site.features.server_version.title') }}</div>
        <div class="feature-value">{{ __('site.features.server_version.value') }}</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">⚔️</div>
        <div class="feature-title">{{ __('site.features.pvp_mode.title') }}</div>
        <div class="feature-value">{{ __('site.features.pvp_mode.value') }}</div>
    </div>
</div>

<!-- News Article Popup -->
<div id="newsPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); z-index: 10000; overflow-y: auto; padding: 20px;">
    <div style="position: relative; max-width: 900px; margin: 50px auto; background: linear-gradient(135deg, #1a0f2e, #2a1b3d); border: 2px solid rgba(147, 112, 219, 0.4); border-radius: 20px; padding: 40px; box-shadow: 0 20px 60px rgba(147, 112, 219, 0.6); color: #e6d7f0;">
        <button onclick="closeNewsPopup()" style="position: absolute; top: 20px; right: 20px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 50%; width: 40px; height: 40px; color: #ef4444; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease; z-index: 1; line-height: 1;">
            ×
        </button>
        
        <div id="newsContent" style="font-family: Arial, sans-serif;">
            <!-- Article content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* News Grid */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
    position: relative;
    z-index: 1;
}

.news-card {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
    border: 2px solid rgba(147, 112, 219, 0.4);
    border-radius: 20px;
    padding: 30px;
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
    transform: translateY(-15px) scale(1.02);
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
    font-size: 1.6rem;
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

.news-date {
    display: flex;
    align-items: center;
    gap: 5px;
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

/* Server Features */
.server-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.feature-card {
    background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
    backdrop-filter: blur(15px);
    border: 1px solid rgba(147, 112, 219, 0.3);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    transition: transform 0.3s ease;
    position: relative;
    overflow: hidden;
}

.feature-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #9370db, #8a2be2, #4b0082);
    animation: progressBar 3s ease-in-out infinite;
}

@keyframes progressBar {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.feature-card:hover {
    transform: translateY(-8px);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #9370db;
    text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
}

.feature-title {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #b19cd9;
}

.feature-value {
    font-size: 1.1rem;
    color: #8a2be2;
    font-weight: 600;
}
</style>
@endsection