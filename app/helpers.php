<?php

if (!function_exists('getThemeVariables')) {
    function getThemeVariables($theme = null)
    {
        if (!$theme) {
            $theme = Auth::check() ? (Auth::user()->theme ?? 'mystical-purple') : 'mystical-purple';
        }
        
        $themes = [
            'mystical-purple' => [
                'body_bg' => 'radial-gradient(ellipse at center, #2a1b3d 0%, #1a0f2e 50%, #0a0514 100%)',
                'text_color' => '#e6d7f0',
                'primary_color' => '#9370db',
                'secondary_color' => '#8a2be2',
                'accent_color' => '#b19cd9',
                'surface_color' => 'rgba(147, 112, 219, 0.1)',
                'border_color' => 'rgba(147, 112, 219, 0.3)',
                'mystical_bg' => 'radial-gradient(circle at 20% 30%, rgba(138, 43, 226, 0.15) 0%, transparent 50%), radial-gradient(circle at 80% 70%, rgba(75, 0, 130, 0.12) 0%, transparent 50%), radial-gradient(circle at 50% 50%, rgba(148, 0, 211, 0.08) 0%, transparent 50%)',
                'particle_color' => '#9370db',
                'particle_shadow' => 'rgba(147, 112, 219, 0.5)',
                'dragon_color' => '#9370db',
                'logo_gradient' => 'linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082)',
                'button_gradient' => 'linear-gradient(45deg, #9370db, #8a2be2)',
                'footer_bg' => 'linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05))',
            ],
            'dark-gaming' => [
                'body_bg' => 'radial-gradient(ellipse at center, #0a0a0a 0%, #1a1a1a 50%, #000000 100%)',
                'text_color' => '#ffffff',
                'primary_color' => '#00ff88',
                'secondary_color' => '#ff0080',
                'accent_color' => '#cccccc',
                'surface_color' => 'rgba(0, 255, 136, 0.1)',
                'border_color' => 'rgba(0, 255, 136, 0.3)',
                'mystical_bg' => 'radial-gradient(circle at 20% 30%, rgba(0, 255, 136, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 70%, rgba(255, 0, 128, 0.08) 0%, transparent 50%), radial-gradient(circle at 50% 50%, rgba(0, 255, 255, 0.05) 0%, transparent 50%)',
                'particle_color' => '#00ff88',
                'particle_shadow' => 'rgba(0, 255, 136, 0.6)',
                'dragon_color' => '#00ff88',
                'logo_gradient' => 'linear-gradient(45deg, #00ff88, #ff0080, #00ff88, #00ffff)',
                'button_gradient' => 'linear-gradient(45deg, #00ff88, #00ffff)',
                'footer_bg' => 'linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 255, 136, 0.05))',
            ],
        ];
        
        return $themes[$theme] ?? $themes['mystical-purple'];
    }
}