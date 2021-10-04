<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sitesetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sitesetting::create([
            'name' => 'New Website',
            'email' => 'test@mail.com',
            'phone' => '01xxxxxxxxxxx',
            'address' => '',
        ]);
    }
}
