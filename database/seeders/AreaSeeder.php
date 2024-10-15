<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Organon\Delivery\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'أشرفية صحنايا', 
            'التل',
            'المعضمية',
            'النبك',
            'جديدة عرطوز البلد',
            'دمر',
            'دير عطية',
            'صحنايا',
            'ضاحية الأسد',
            'ضاحية قدسيا',
            'قدسيا',
            'مشروع دمر',
            'معربا',
            'يبرود'
        ];

        foreach($areas as $name){
            $area = Area::create([
                'name' => $name,
                'info' => '',
                'is_active' => true
            ]);
            // $area->addMediaFromDisk('images/areas/' . $name . '.png')->preservingOriginal()->toMediaCollection('image', 'public');
        }
    }
}
