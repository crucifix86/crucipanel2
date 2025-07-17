<div>
    <form wire:submit.prevent="updateTheme">
        <div class="form-group mb-4">
            <label class="form-label" for="theme">{{ __('site.profile.sections.theme.select_theme') }}</label>
            <select wire:model="selectedThemeId" id="theme" class="form-select">
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ $theme->id == $selectedThemeId ? 'selected' : '' }}>
                        {{ $theme->display_name }}
                        @if($theme->description)
                            - {{ $theme->description }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>{{ __('site.profile.sections.theme.save_button') }}
            </button>
        </div>
    </form>
    
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
</div>