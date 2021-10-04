<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SiteSettingSeeder::class);
        $this->call(SeederVendorBusinessTypes::class);
        $this->call([SeederVendorBusinessNature::class]);
        $this->call(SeederVendorProductTypes::class);
        $this->call(SeederProductUnits::class);
        $this->call(SeederSiteFeatures::class);
        $this->call(SeederCountry::class);
        $this->call(SeederAdmin::class);
        $this->call(SeederVendor::class);
        $this->call(SeederColorSize::class);
        $this->call(SeederWarrentyMonthYear::class);
        $this->call(SeederVat::class);


    }
}
