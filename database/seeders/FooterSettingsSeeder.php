<?php

namespace Database\Seeders;

use App\Models\FooterSetting;
use App\Models\SocialLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default footer settings
        FooterSetting::updateOrCreate(
            ['id' => 1],
            [
                'content' => 'Connect socially with <strong>' . config('pw-config.server_name', 'Your Server') . '</strong>',
                'copyright' => date('Y') . ' &copy; <strong>' . config('pw-config.server_name', 'Your Server') . '</strong>. All rights reserved'
            ]
        );
        
        // Create default social links
        $socialLinks = [
            [
                'platform' => 'YouTube',
                'url' => 'https://youtube.com/c/hrace009',
                'icon' => 'fa-brands fa-youtube',
                'order' => 0,
                'active' => true
            ],
            [
                'platform' => 'Twitter',
                'url' => 'https://twitter.com/hrace009',
                'icon' => 'fa-brands fa-twitter',
                'order' => 1,
                'active' => true
            ]
        ];
        
        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}
