@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.profile.title'))

@section('styles')
@parent
    <style>
        /* Profile-specific styles */
        .profile-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
            margin-top: 20px;
        }

        @media (max-width: 1024px) {
            .profile-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        /* Profile Sidebar */
        .profile-sidebar {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 30px;
            padding: 30px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(147, 112, 219, 0.2);
            position: relative;
            overflow: hidden;
            height: fit-content;
        }

        .profile-avatar-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.3), rgba(75, 0, 130, 0.3));
            border: 3px solid rgba(147, 112, 219, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-username {
            font-size: 1.8rem;
            color: #9370db;
            margin-bottom: 8px;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);
        }

        .profile-email {
            color: #b19cd9;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .stat-item {
            padding: 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 15px;
            text-align: center;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.1rem;
            color: #9370db;
            font-weight: 600;
        }

        /* Profile Content Area */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .profile-section {
            background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
            backdrop-filter: blur(20px);
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(147, 112, 219, 0.2);
            position: relative;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }

        .section-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(147, 112, 219, 0.5);
            flex-shrink: 0;
        }

        .section-title {
            font-size: 1.8rem;
            color: #9370db;
            margin-bottom: 8px;
            text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);
        }

        .section-description {
            color: #b19cd9;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Character section styling */
        .character-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .character-card {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(147, 112, 219, 0.4);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .character-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(147, 112, 219, 0.3);
        }

        /* Success notification */
        #success-notification {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            padding: 20px 40px;
            border-radius: 15px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: none;
        }

        @media (max-width: 768px) {
            .profile-section {
                padding: 25px 20px;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div id="success-notification">
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
                            <i class="fas fa-user" style="font-size: 3rem; color: #9370db;"></i>
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
                        <div>
                            <h3 class="section-title">{{ __('site.profile.sections.profile_info.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.profile_info.description') }}</p>
                        </div>
                    </div>
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif
            
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div>
                        <h3 class="section-title">{{ __('site.profile.sections.language.title') }}</h3>
                        <p class="section-description">{{ __('site.profile.sections.language.description') }}</p>
                    </div>
                </div>
                @livewire('profile.language-preference')
            </div>
            
            @if ( $api->online )
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('site.profile.sections.characters.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.characters.description') }}</p>
                        </div>
                    </div>
                    @livewire('profile.list-character')
                </div>
            @endif
            
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('site.profile.sections.password.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.password.description') }}</p>
                        </div>
                    </div>
                    @livewire('profile.update-password-form')
                </div>
                
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('site.profile.sections.pin.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.pin.description') }}</p>
                        </div>
                    </div>
                    @livewire('profile.pin-settings')
                </div>
            @endif
            
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3 class="section-title">{{ __('site.profile.sections.sessions.title') }}</h3>
                        <p class="section-description">{{ __('site.profile.sections.sessions.description') }}</p>
                    </div>
                </div>
                @livewire('profile.logout-from-other-browser')
            </div>
            
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon" style="background: linear-gradient(45deg, #dc2626, #b91c1c);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 class="section-title">{{ __('site.profile.sections.delete_account.title') }}</h3>
                            <p class="section-description">{{ __('site.profile.sections.delete_account.description') }}</p>
                        </div>
                    </div>
                    @livewire('profile.delete-user-form')
                </div>
            @endif
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