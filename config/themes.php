<?php

return [
    'default' => 'default',
    
    'themes' => [
        'default' => [
            'name' => 'Default Theme',
            'description' => 'Modern clean theme with gradient accents',
            'css' => 'css/themes/default.css',
            'preview' => 'img/themes/default.png',
            'colors' => [
                'primary' => '#3b82f6',
                'secondary' => '#8b5cf6',
                'accent' => '#06b6d4',
                'background' => '#f8fafc',
                'surface' => '#ffffff',
                'text' => '#111827'
            ]
        ],
        'gamer-dark' => [
            'name' => 'Gamer Dark',
            'description' => 'Modern dark theme with neon accents for gamers',
            'css' => 'css/themes/gamer-dark.css',
            'preview' => 'img/themes/gamer-dark.png',
            'colors' => [
                'primary' => '#00ff88',
                'secondary' => '#ff0080',
                'accent' => '#00ffff',
                'background' => '#0a0a0a',
                'surface' => '#1a1a1a',
                'text' => '#ffffff'
            ]
        ],
        'cyberpunk' => [
            'name' => 'Cyberpunk 2077',
            'description' => 'Futuristic theme with yellow and pink neon',
            'css' => 'css/themes/cyberpunk.css',
            'preview' => 'img/themes/cyberpunk.png',
            'colors' => [
                'primary' => '#fcee09',
                'secondary' => '#ff0080',
                'accent' => '#00ffff',
                'background' => '#000000',
                'surface' => '#1a0f1a',
                'text' => '#ffffff'
            ]
        ]
    ]
];