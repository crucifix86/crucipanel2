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