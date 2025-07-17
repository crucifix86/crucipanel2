<form wire:submit="updatePublicProfile" class="profile-form">
    <div class="form-section">
        <h4 class="form-section-title">{{ __('site.profile.public.settings_title') }}</h4>
        
        <div class="form-group">
            <label class="toggle-label">
                <input type="checkbox" wire:model="public_profile_enabled" class="toggle-input">
                <span class="toggle-switch"></span>
                <span class="toggle-text">{{ __('site.profile.public.enable_profile') }}</span>
            </label>
            <p class="form-help">{{ __('site.profile.public.enable_profile_help') }}</p>
        </div>

        <div class="form-group">
            <label class="toggle-label">
                <input type="checkbox" wire:model="public_wall_enabled" class="toggle-input">
                <span class="toggle-switch"></span>
                <span class="toggle-text">{{ __('site.profile.public.enable_wall') }}</span>
            </label>
            <p class="form-help">{{ __('site.profile.public.enable_wall_help') }}</p>
        </div>
    </div>

    <div class="form-section">
        <h4 class="form-section-title">{{ __('site.profile.public.info_title') }}</h4>
        
        <div class="form-group">
            <label for="public_bio" class="form-label">{{ __('site.profile.public.bio') }}</label>
            <textarea 
                id="public_bio"
                wire:model="public_bio"
                rows="4"
                class="form-textarea"
                placeholder="{{ __('site.profile.public.bio_placeholder') }}"
                maxlength="1000"
            ></textarea>
            <p class="form-help">{{ __('site.profile.public.bio_help') }}</p>
            @error('public_bio') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="public_discord" class="form-label">{{ __('site.profile.public.discord') }}</label>
            <input 
                type="text" 
                id="public_discord"
                wire:model="public_discord"
                class="form-input"
                placeholder="{{ __('site.profile.public.discord_placeholder') }}"
                maxlength="100"
            >
            @error('public_discord') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="public_website" class="form-label">{{ __('site.profile.public.website') }}</label>
            <input 
                type="url" 
                id="public_website"
                wire:model="public_website"
                class="form-input"
                placeholder="{{ __('site.profile.public.website_placeholder') }}"
                maxlength="255"
            >
            @error('public_website') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>{{ __('site.profile.save_changes') }}</span>
            <span wire:loading>{{ __('site.profile.saving') }}</span>
        </button>
        
        @auth
            <a href="{{ route('public.profile', Auth::user()->name) }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-external-link-alt mr-2"></i>{{ __('site.profile.public.view_profile') }}
            </a>
        @endauth
    </div>

    <x-action-message class="mt-3" on="saved">
        {{ __('site.profile.saved') }}
    </x-action-message>
</form>