<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeaderSetting;

class HeaderSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeaderSetting::firstOrCreate(
            ['id' => 1],
            [
                'content' => '<div class="logo-container">
    <h1 class="logo">Haven Perfect World</h1>
    <p class="tagline">Embark on the Path of Immortals</p>
</div>',
                'alignment' => 'center',
                'header_logo' => 'img/logo/haven_perfect_world_logo.svg',
                'badge_logo' => 'img/logo/crucifix_logo.svg'
            ]
        );
    }
}