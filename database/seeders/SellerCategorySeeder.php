<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Organon\Marketplace\Models\SellerCategory;

class SellerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellerCategories = [
            'طبي',
            'تموينات',
            'مشروبات روحية',
            'التكنولوجيا والالكترونيات',
            'الموضة والأزياء',
            'تعليم',
            'رياضة',
            'الجمال والعناية الشخصية',
            'الأثاثات المنزلية',
            'مأكولات ومشروبات',
            'مخابز وحلويات',
            'مقاهي',
            'السياحة والضيافة',
            'النقل والشحن',
            'المصارف والتمويل',
            'الخدمات',
            'مواد البناء',
            'المجوهرات',
            'عقارات وسيارات',
            'اكسسوارات وهدايا وألعاب',
            'المصانع',
            'الحرف اليدوية',
            'الزراعة والبستنة',
        ];

        foreach ($sellerCategories as $name) {
            $sellerCategory = SellerCategory::create([
                'name' => $name,
                'parent_id' => null,
            ]);
            $sellerCategory->addMediaFromDisk('images/categories/' . 'placeholder' . '.png')->preservingOriginal()->toMediaCollection('image', 'public');
            for ($i = 0; $i < 15; $i++)
                SellerCategory::create([
                    'name' => $name . ' ' . $i,
                    'parent_id' => $sellerCategory->id,
                ])->addMediaFromDisk('images/categories/' . 'placeholder' . '.png')->preservingOriginal()->toMediaCollection('image', 'public');
        }
    }
}
