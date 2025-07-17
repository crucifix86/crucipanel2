@extends('layouts.mystical')

@section('title', __('site.members.title') . ' - ' . config('pw-config.server_name', 'Haven Perfect World'))

@section('body-class', 'members-page')

@section('content')
<div class="members-content">
    <div class="members-header">
        <h1 class="members-title">{{ __('site.members.community_members') }}</h1>
    </div>
    
    <!-- Staff Members Section -->
    @if(count($gms) > 0)
    <div class="staff-section">
        <h2 class="section-title">
            <span class="title-icon">👑</span>
            {{ __('site.members.staff_members') }}
        </h2>
        <div class="staff-grid">
            @foreach($gms as $gm)
            <div class="staff-card">
                <div class="staff-avatar-wrapper">
                    <img src="{{ $gm->profile_photo_url }}" alt="{{ $gm->truename ?? $gm->name }}" class="staff-avatar">
                    <div class="staff-badge {{ $gm->isAdministrator() ? 'badge-admin' : 'badge-gm' }}">
                        {{ $gm->isAdministrator() ? '👑' : '⚔️' }}
                    </div>
                </div>
                <h3 class="staff-name">{{ $gm->truename ?? $gm->name }}</h3>
                <div class="staff-role {{ $gm->isAdministrator() ? 'role-admin' : 'role-gm' }}">
                    {{ $gm->isAdministrator() ? __('site.members.administrator') : __('site.members.game_master') }}
                </div>
                <div class="staff-info">
                    <span class="info-icon">📅</span>
                    {{ __('site.members.member_since', ['date' => $gm->created_at->format('M Y')]) }}
                </div>
                
                @php
                    $gmCharacters = $gm->roles();
                @endphp
                @if(count($gmCharacters) > 0)
                    <div class="character-section">
                        <button onclick="toggleCharacters('gm-chars-{{ $gm->ID }}')" class="character-toggle">
                            <span class="toggle-icon">🎮</span>
                            {{ __('site.members.characters', ['count' => count($gmCharacters)]) }}
                            <span class="toggle-arrow">▼</span>
                        </button>
                        <div id="gm-chars-{{ $gm->ID }}" class="character-list" style="display: none;">
                            @foreach($gmCharacters as $character)
                                @php
                                    $isOnline = isset($onlineCharacters[$character['id']]);
                                @endphp
                                <div class="character-item {{ $isOnline ? 'online' : 'offline' }}">
                                    <span class="status-dot"></span>
                                    <span class="character-name">{{ $character['name'] ?? __('site.members.unknown') }}</span>
                                    @if($isOnline)
                                        <span class="online-badge">{{ __('site.members.online') }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if($gm->discord_id)
                    <div class="discord-info">
                        <svg class="discord-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                        </svg>
                        <span class="discord-username">{{ $gm->discord_id }}</span>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Registered Players Section -->
    <div class="players-section">
        <h2 class="section-title">
            <span class="title-icon">🎮</span>
            {{ __('site.members.registered_players', ['count' => $totalMembers ?? count($members)]) }}
        </h2>
        
        <!-- Search Box -->
        <div class="search-container">
            <form method="GET" action="{{ route('public.members') }}" class="search-form">
                <div class="search-wrapper">
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="{{ __('site.members.search_placeholder') }}" 
                           class="search-input">
                    <button type="submit" class="search-button">
                        <span class="button-icon">🔍</span>
                        {{ __('site.members.search_button') }}
                    </button>
                    @if($search)
                        <a href="{{ route('public.members') }}" class="clear-search">
                            {{ __('site.members.clear') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Players Table -->
        <div class="players-table-wrapper">
            @if(count($members) > 0)
                <table class="players-table">
                    <thead>
                        <tr>
                            <th>{{ __('site.members.table.player') }}</th>
                            <th>{{ __('site.members.table.characters') }}</th>
                            <th>{{ __('site.members.table.member_since') }}</th>
                            <th>{{ __('site.members.table.discord') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr class="player-row">
                            <td class="player-info">
                                <img src="{{ $member->profile_photo_url }}" alt="{{ $member->truename ?? $member->name }}" class="player-avatar">
                                <span class="player-name">{{ $member->truename ?? $member->name }}</span>
                            </td>
                            <td class="character-cell">
                                @php
                                    $characters = $member->roles();
                                @endphp
                                @if(count($characters) > 0)
                                    <button onclick="toggleCharacters('chars-{{ $member->ID }}')" class="character-button">
                                        <span class="button-icon">🎭</span>
                                        {{ __('site.members.characters', ['count' => count($characters)]) }}
                                        <span class="arrow-icon">▼</span>
                                    </button>
                                    <div id="chars-{{ $member->ID }}" class="character-dropdown" style="display: none;">
                                        @foreach($characters as $character)
                                            @php
                                                $isOnline = isset($onlineCharacters[$character['id']]);
                                            @endphp
                                            <div class="character-entry {{ $isOnline ? 'online' : '' }}">
                                                @if($isOnline)
                                                    <span class="online-indicator">●</span>
                                                @endif
                                                <span class="char-name">{{ $character['name'] ?? __('site.members.unknown') }}</span>
                                                @if($isOnline)
                                                    <span class="online-text">({{ __('site.members.online') }})</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="no-characters">{{ __('site.members.no_characters') }}</span>
                                @endif
                            </td>
                            <td class="date-cell">
                                <span class="date-icon">📅</span>
                                {{ $member->created_at->format('M d, Y') }}
                            </td>
                            <td class="discord-cell">
                                @if($member->discord_id)
                                    <div class="discord-badge">
                                        <svg class="discord-icon-small" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                                        </svg>
                                        {{ $member->discord_id }}
                                    </div>
                                @else
                                    <span class="no-discord">{{ __('site.members.not_shared') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-results">
                    <span class="no-results-icon">🔍</span>
                    <p class="no-results-text">{{ __('site.members.no_players') }}</p>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if(isset($totalPages) && $totalPages > 1)
            <div class="pagination">
                @if($page > 1)
                    <a href="?page={{ $page - 1 }}{{ $search ? '&search=' . $search : '' }}" class="pagination-link pagination-prev">
                        <span class="pagination-arrow">←</span>
                        {{ __('site.members.pagination.previous') }}
                    </a>
                @endif
                
                <span class="pagination-info">
                    {{ __('site.members.pagination.page_of', ['current' => $page, 'total' => $totalPages]) }}
                </span>
                
                @if($page < $totalPages)
                    <a href="?page={{ $page + 1 }}{{ $search ? '&search=' . $search : '' }}" class="pagination-link pagination-next">
                        {{ __('site.members.pagination.next') }}
                        <span class="pagination-arrow">→</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    // Toggle character dropdown
    function toggleCharacters(id) {
        const element = document.getElementById(id);
        const button = element.previousElementSibling;
        
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block';
            // Update arrow
            const arrow = button.querySelector('.toggle-arrow, .arrow-icon');
            if (arrow) arrow.textContent = '▲';
        } else {
            element.style.display = 'none';
            // Update arrow
            const arrow = button.querySelector('.toggle-arrow, .arrow-icon');
            if (arrow) arrow.textContent = '▼';
        }
    }
    
    // Add hover effect to table rows
    document.querySelectorAll('.player-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
</script>
@endsection