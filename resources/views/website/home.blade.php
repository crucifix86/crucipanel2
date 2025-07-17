@extends('layouts.mystical')

@section('title', 'Haven Perfect World')

@section('body-class', 'home-page')

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
            <div class="no-news">
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
<div id="newsPopup" class="news-popup">
    <div class="news-popup-content">
        <button onclick="closeNewsPopup()" class="news-popup-close">
            ×
        </button>
        
        <div id="newsContent" class="news-popup-body">
            <!-- Article content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openNewsPopup(slug) {
    document.getElementById('newsPopup').style.display = 'block';
    document.body.style.overflow = 'hidden';
    // Add AJAX call here to fetch news content
}

function closeNewsPopup() {
    document.getElementById('newsPopup').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close popup when clicking outside
document.addEventListener('click', function(event) {
    const popup = document.getElementById('newsPopup');
    if (event.target === popup) {
        closeNewsPopup();
    }
});
</script>
@endsection