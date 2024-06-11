<?php

namespace Organon\Marketplace\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{

    private $counter = 1;

    private function insertThemeCustomizationTranslation($theme_id, $options)
    {
        DB::table('theme_customization_translations')
            ->insert([
                [
                    'theme_customization_id' => $theme_id,
                    'locale' => 'en',
                    'options' => $options,
                ]
            ]);
    }

    private function insertThemeCustomization($type, $name, $options)
    {
        DB::table('theme_customizations')
            ->insert([
                [
                    'id' => $this->counter,
                    'type' => $type,
                    'name' => $name,
                    'sort_order' => $this->counter,
                    'status' => 1,
                ]
            ]);
        $this->insertThemeCustomizationTranslation($this->counter, $options);
        $this->counter++;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        

    }
}
