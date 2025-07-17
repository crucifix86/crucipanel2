@extends('layouts.mystical')

@section('title', $user->truename ?? $user->name . ' - ' . config('pw-config.server_name', 'Haven Perfect World'))

@section('body-class', 'public-profile-page')

@section('content')
<div class="public-profile-container">
    <div class="profile-header">
        <div class="profile-banner"></div>
        <div class="profile-info">
            <div class="profile-avatar">
                @if ($user->profile_photo_path)
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <div class="profile-details">
                <h1 class="profile-name">{{ $user->truename ?? $user->name }}</h1>
                <p class="profile-joined">{{ __('profile.public.member_since', ['date' => $user->created_at->format('F Y')]) }}</p>
                @if(Auth::check() && Auth::id() !== $user->id)
                    <div class="profile-actions">
                        <a href="{{ route('messages.compose', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-envelope mr-2"></i>{{ __('messages.send_message') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="profile-tabs-nav">
        <button class="tab-button active" onclick="switchTab('info', event)">
            <i class="fas fa-info-circle"></i> {{ __('profile.public.tab_info') }}
        </button>
        <button class="tab-button" onclick="switchTab('characters', event)">
            <i class="fas fa-gamepad"></i> {{ __('profile.public.tab_characters') }} ({{ count($characters) }})
        </button>
        @if($wallEnabled)
        <button class="tab-button" onclick="switchTab('wall', event)">
            <i class="fas fa-comments"></i> {{ __('profile.public.tab_wall') }} ({{ $wallMessages->total() }})
        </button>
        @endif
    </div>

    <!-- Tab Contents -->
    <div class="profile-tabs-content">
        <!-- Info Tab -->
        <div id="info-tab" class="tab-content active">
            <div class="info-grid">
                @if($user->profile && $user->profile->public_bio)
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-user"></i> {{ __('profile.public.about') }}</h3>
                    <p class="info-bio">{{ $user->profile->public_bio }}</p>
                </div>
                @endif

                @if($user->profile && ($user->profile->public_discord || $user->profile->public_website))
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-link"></i> {{ __('profile.public.links') }}</h3>
                    <div class="info-links">
                        @if($user->profile->public_discord)
                        <div class="info-link">
                            <i class="fab fa-discord"></i>
                            <span>{{ $user->profile->public_discord }}</span>
                        </div>
                        @endif
                        @if($user->profile->public_website)
                        <div class="info-link">
                            <i class="fas fa-globe"></i>
                            <a href="{{ $user->profile->public_website }}" target="_blank" rel="noopener">{{ parse_url($user->profile->public_website, PHP_URL_HOST) }}</a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-chart-bar"></i> {{ __('profile.public.stats') }}</h3>
                    <div class="info-stats">
                        <div class="stat">
                            <span class="stat-label">{{ __('profile.public.total_characters') }}</span>
                            <span class="stat-value">{{ count($characters) }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">{{ __('profile.public.wall_posts') }}</span>
                            <span class="stat-value">{{ $wallEnabled ? $wallMessages->total() : 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Characters Tab -->
        <div id="characters-tab" class="tab-content">
            <div class="characters-grid">
                @forelse($characters as $character)
                <div class="character-card">
                    <div class="character-icon">
                        <i class="fas fa-user-ninja"></i>
                    </div>
                    <h4 class="character-name">{{ $character['name'] }}</h4>
                    <p class="character-level">{{ __('profile.public.level') }} {{ $character['level'] ?? '?' }}</p>
                    <p class="character-class">{{ $character['occupation'] ?? __('profile.public.unknown_class') }}</p>
                </div>
                @empty
                <p class="no-characters">{{ __('profile.public.no_characters') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Wall Tab -->
        @if($wallEnabled)
        <div id="wall-tab" class="tab-content">
            @auth
            <div class="wall-post-form">
                <form action="{{ route('profile.wall.store', $user->name) }}" method="POST">
                    @csrf
                    <textarea 
                        name="message" 
                        placeholder="{{ __('messages.wall_message_placeholder') }}"
                        rows="3"
                        maxlength="500"
                        required
                    ></textarea>
                    <div class="form-actions">
                        <span class="char-count">0/500</span>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> {{ __('messages.post_message') }}
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="login-prompt">
                <p>{{ __('profile.public.login_to_post') }}</p>
                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('auth.login') }}</a>
            </div>
            @endauth

            <div class="wall-messages">
                @forelse($wallMessages as $message)
                <div class="wall-message">
                    <div class="message-header">
                        <div class="message-author">
                            <img src="{{ $message->sender->profile_photo_url }}" alt="{{ $message->sender->name }}" class="author-avatar">
                            <div class="author-info">
                                <a href="{{ route('public.profile', $message->sender->name) }}" class="author-name">
                                    {{ $message->sender->truename ?? $message->sender->name }}
                                </a>
                                <span class="message-time">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if(Auth::check() && (Auth::id() === $user->id || Auth::id() === $message->sender_id))
                        <form action="{{ route('profile.wall.destroy', ['username' => $user->name, 'message' => $message->id]) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="message-content">
                        {{ $message->message }}
                    </div>
                </div>
                @empty
                <p class="no-messages">{{ __('messages.no_wall_messages') }}</p>
                @endforelse
            </div>

            @if($wallMessages->hasPages())
            <div class="pagination-wrapper">
                {{ $wallMessages->links() }}
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

<style>
.public-profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.profile-header {
    background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(138, 43, 226, 0.1));
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 30px;
    border: 1px solid rgba(147, 112, 219, 0.3);
}

.profile-banner {
    height: 200px;
    background: linear-gradient(135deg, #9370DB, #8A2BE2);
    opacity: 0.8;
}

.profile-info {
    display: flex;
    align-items: flex-end;
    padding: 0 30px 30px;
    margin-top: -50px;
    position: relative;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(30, 30, 60, 0.95);
    border: 4px solid #9370DB;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar i {
    font-size: 60px;
    color: #9370DB;
}

.profile-details {
    flex: 1;
}

.profile-name {
    font-size: 2rem;
    color: #e6d7f0;
    margin: 0;
}

.profile-joined {
    color: #9370DB;
    margin: 5px 0;
}

.profile-actions {
    margin-top: 15px;
}

/* Tabs */
.profile-tabs-nav {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    border-bottom: 2px solid rgba(147, 112, 219, 0.3);
}

.tab-button {
    background: none;
    border: none;
    color: #e6d7f0;
    padding: 15px 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    font-size: 1rem;
}

.tab-button:hover {
    color: #9370DB;
}

.tab-button.active {
    color: #9370DB;
}

.tab-button.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: #9370DB;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Info Tab */
.info-grid {
    display: grid;
    gap: 30px;
}

.info-section {
    background: rgba(30, 30, 60, 0.6);
    padding: 25px;
    border-radius: 10px;
    border: 1px solid rgba(147, 112, 219, 0.3);
}

.info-title {
    color: #9370DB;
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.info-bio {
    color: #e6d7f0;
    line-height: 1.8;
}

.info-link {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #e6d7f0;
    margin-bottom: 10px;
}

.info-link a {
    color: #9370DB;
    text-decoration: none;
}

.info-link a:hover {
    text-decoration: underline;
}

.info-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

.stat {
    text-align: center;
}

.stat-label {
    display: block;
    color: #9370DB;
    margin-bottom: 5px;
}

.stat-value {
    display: block;
    font-size: 2rem;
    color: #e6d7f0;
    font-weight: bold;
}

/* Characters Tab */
.characters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.character-card {
    background: rgba(30, 30, 60, 0.6);
    padding: 25px;
    border-radius: 10px;
    border: 1px solid rgba(147, 112, 219, 0.3);
    text-align: center;
    transition: transform 0.3s ease;
}

.character-card:hover {
    transform: translateY(-5px);
}

.character-icon {
    font-size: 3rem;
    color: #9370DB;
    margin-bottom: 15px;
}

.character-name {
    color: #e6d7f0;
    margin: 10px 0;
}

.character-level, .character-class {
    color: #9370DB;
    margin: 5px 0;
}

/* Wall Tab */
.wall-post-form {
    background: rgba(30, 30, 60, 0.6);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    border: 1px solid rgba(147, 112, 219, 0.3);
}

.wall-post-form textarea {
    width: 100%;
    background: rgba(20, 20, 40, 0.8);
    border: 1px solid rgba(147, 112, 219, 0.3);
    color: #e6d7f0;
    padding: 15px;
    border-radius: 5px;
    resize: vertical;
}

.wall-post-form .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.char-count {
    color: #9370DB;
    font-size: 0.9rem;
}

.wall-message {
    background: rgba(30, 30, 60, 0.6);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 1px solid rgba(147, 112, 219, 0.3);
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.message-author {
    display: flex;
    align-items: center;
    gap: 15px;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.author-name {
    color: #9370DB;
    text-decoration: none;
    font-weight: bold;
}

.author-name:hover {
    text-decoration: underline;
}

.message-time {
    color: #9370DB;
    font-size: 0.9rem;
}

.message-content {
    color: #e6d7f0;
    line-height: 1.6;
}

.delete-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
}

.delete-btn:hover {
    color: #ff6b6b;
}

.login-prompt {
    text-align: center;
    padding: 40px;
    background: rgba(30, 30, 60, 0.6);
    border-radius: 10px;
    border: 1px solid rgba(147, 112, 219, 0.3);
}

.no-messages, .no-characters {
    text-align: center;
    color: #9370DB;
    padding: 40px;
}
</style>

@section('scripts')
@parent
<script>
function switchTab(tabName, event) {
    console.log('Switching to tab:', tabName);
    // Remove active class from all tabs and buttons
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    
    // Add active class to selected tab and button
    const tabElement = document.querySelector(`#${tabName}-tab`);
    if (tabElement) {
        tabElement.classList.add('active');
    } else {
        console.error('Tab not found:', tabName + '-tab');
    }
    
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}

// Character counter for wall post
const textarea = document.querySelector('.wall-post-form textarea');
const charCount = document.querySelector('.char-count');

if (textarea && charCount) {
    textarea.addEventListener('input', function() {
        charCount.textContent = `${this.value.length}/500`;
    });
}
</script>
@endsection