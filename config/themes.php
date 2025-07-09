<?php

return [
    'default' => 'default',
    
    'themes' => [
        'default' => [
            'name' => 'Default Theme',
            'description' => 'Classic light theme with dark mode support',
            'css' => null, // Uses default Tailwind classes
            'preview' => 'img/themes/default.png'
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