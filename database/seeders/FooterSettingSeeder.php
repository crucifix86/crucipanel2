<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterSetting;

class FooterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FooterSetting::firstOrCreate(
            ['id' => 1],
            [
                'content' => '<p class="footer-text">Begin your journey through the realms of endless cultivation</p>',
                'copyright' => '&copy; ' . date('Y') . ' Haven Perfect World. All rights reserved.',
                'alignment' => 'center'
            ]
        );
    }
}