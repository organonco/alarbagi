<?php

namespace Webkul\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Organon\Marketplace\Database\Seeders\ContentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocalesTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CountryStateTranslationSeeder::class);
        $this->call(ChannelTableSeeder::class);
        $this->call(ConfigTableSeeder::class);
        $this->call(ContentSeeder::class);
    }
}
