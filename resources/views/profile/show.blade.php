@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.profile.title'))

@section('body-class', 'profile-page')

@section('content')
<div class="profile-container">
    <!-- Success notification -->
    <div id="success-notification" class="success-notification">
        <i class="fas fa-check-circle"></i> {{ __('site.profile.success_message') }}
    </div>
    
    <!-- Profile Grid Layout -->
    <div class="profile-grid">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-avatar-section">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        @if (Auth::user()->profile_photo_path)
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                </div>
                <h2 class="profile-username">{{ Auth::user()->truename ?? Auth::user()->name }}</h2>
                <p class="profile-email">{{ Auth::user()->email }}</p>
            </div>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-label">{{ __('site.profile.sidebar.member_since') }}</div>
                    <div class="stat-value">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">{{ __('site.profile.sidebar.account_status') }}</div>
                    <div class="stat-value">{{ __('site.profile.sidebar.status_active') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="profile-content">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">{{ __('site.profile.sections.profile_info.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.profile_info.description') }}</p>
                        </div>
                    </div>
                    <div class="section-content">
                        @livewire('profile.update-profile-information-form')
                    </div>
                </div>
            @endif
            
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="section-info">
                        <h3 class="section-title">{{ __('site.profile.sections.theme.title') }}</h3>
                        <p class="section-description">{{ __('site.profile.sections.theme.description') }}</p>
                    </div>
                </div>
                <div class="section-content">
                    @livewire('profile.theme-selector')
                </div>
            </div>
            
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="section-info">
                        <h3 class="section-title">{{ __('site.profile.sections.language.title') }}</h3>
                        <p class="section-description">{{ __('site.profile.sections.language.description') }}</p>
                    </div>
                </div>
                <div class="section-content">
                    @livewire('profile.language-preference')
                </div>
            </div>
            
            @if ( $api->online )
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">{{ __('site.profile.sections.characters.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.characters.description') }}</p>
                        </div>
                    </div>
                    <div class="section-content">
                        @livewire('profile.list-character')
                    </div>
                </div>
            @endif
            
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">{{ __('site.profile.sections.password.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.password.description') }}</p>
                        </div>
                    </div>
                    <div class="section-content">
                        @livewire('profile.update-password-form')
                    </div>
                </div>
                
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">{{ __('site.profile.sections.pin.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.pin.description') }}</p>
                        </div>
                    </div>
                    <div class="section-content">
                        @livewire('profile.pin-settings')
                    </div>
                </div>
            @endif
            
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="section-info">
                        <h3 class="section-title">{{ __('site.profile.sections.sessions.title') }}</h3>
                        <p class="section-description">{{ __('site.profile.sections.sessions.description') }}</p>
                    </div>
                </div>
                <div class="section-content">
                    @livewire('profile.logout-from-other-browser')
                </div>
            </div>
            
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="profile-section danger-section">
                    <div class="section-header">
                        <div class="section-icon danger-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">{{ __('site.profile.sections.delete_account.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.delete_account.description') }}</p>
                        </div>
                    </div>
                    <div class="section-content">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    // Success notification display
    function showSuccessNotification() {
        const notification = document.getElementById('success-notification');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Listen for Livewire events
    document.addEventListener('livewire:load', function () {
        Livewire.on('profileUpdated', () => {
            showSuccessNotification();
        });
    });
</script>
@endsection