<div class="theme-preference-container">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="theme-options">
        @foreach($themes as $themeKey => $theme)
            <div class="theme-option {{ $currentTheme === $themeKey ? 'active' : '' }}" 
                 wire:click="selectTheme('{{ $themeKey }}')" 
                 style="cursor: pointer;">
                <div class="theme-preview">
                    @if($themeKey === 'mystical-purple')
                        <div class="preview-box mystical-preview">
                            <div class="preview-gradient"></div>
                            <div class="preview-particle"></div>
                        </div>
                    @elseif($themeKey === 'dark-gaming')
                        <div class="preview-box dark-gaming-preview">
                            <div class="preview-gradient"></div>
                            <div class="preview-accent"></div>
                        </div>
                    @endif
                </div>
                <div class="theme-info">
                    <h4 class="theme-name">{{ $theme['name'] }}</h4>
                    <p class="theme-description">{{ $theme['description'] }}</p>
                    @if($currentTheme === $themeKey)
                        <span class="current-badge">Current</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <style>
        .theme-preference-container {
            width: 100%;
        }
        
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }
        
        .theme-options {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .theme-option {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border: 2px solid rgba(147, 112, 219, 0.3);
            border-radius: 15px;
            background: rgba(147, 112, 219, 0.05);
            transition: all 0.3s ease;
        }
        
        .theme-option:hover {
            border-color: rgba(147, 112, 219, 0.6);
            background: rgba(147, 112, 219, 0.1);
            transform: translateY(-2px);
        }
        
        .theme-option.active {
            border-color: #9370db;
            background: rgba(147, 112, 219, 0.2);
            box-shadow: 0 0 20px rgba(147, 112, 219, 0.4);
        }
        
        .theme-preview {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(147, 112, 219, 0.3);
        }
        
        .preview-box {
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        .mystical-preview {
            background: radial-gradient(ellipse at center, #2a1b3d 0%, #1a0f2e 50%, #0a0514 100%);
        }
        
        .mystical-preview .preview-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 30%, rgba(138, 43, 226, 0.3) 0%, transparent 50%);
        }
        
        .mystical-preview .preview-particle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 4px;
            height: 4px;
            background: #9370db;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 10px rgba(147, 112, 219, 0.8);
        }
        
        .dark-gaming-preview {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        }
        
        .dark-gaming-preview .preview-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 255, 136, 0.2) 0%, transparent 50%);
        }
        
        .dark-gaming-preview .preview-accent {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 8px;
            height: 2px;
            background: #00ff88;
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(0, 255, 136, 0.6);
        }
        
        .theme-info {
            flex: 1;
            position: relative;
        }
        
        .theme-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #9370db;
            margin-bottom: 8px;
            text-shadow: 0 0 10px rgba(147, 112, 219, 0.5);
        }
        
        .theme-description {
            font-size: 0.9rem;
            color: #b19cd9;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .current-badge {
            display: inline-block;
            background: linear-gradient(45deg, #9370db, #8a2be2);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-shadow: none;
        }
        
        @media (max-width: 768px) {
            .theme-options {
                grid-template-columns: 1fr;
            }
            
            .theme-option {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</div>