<?php

namespace Organon\Marketplace\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{

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

    private function insertThemeCustomization($id, $type, $name, $order, $options)
    {
        DB::table('theme_customizations')
            ->insert([
                [
                    'id' => $id,
                    'type' => $type,
                    'name' => $name,
                    'sort_order' => $order,
                    'status' => 1,
                ]
            ]);
        $this->insertThemeCustomizationTranslation($id, $options);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->insertThemeCustomization(1, 'image_carousel', 'Top Banner', 1, json_encode([
            'images' => [
                ['link' => '', 'image' => 'storage/theme/1/1.webp'], ['link' => '', 'image' => 'storage/theme/1/2.webp',]
            ],
        ]));

        $this->insertThemeCustomization(2, 'static_content', 'Trending Categories Label', 2, json_encode([
            'html' => '<div class="top-collection-container"><div class="top-collection-header"><h2>Trending Categories</h2></div></div>',
            'css' => '.top-collection-header {padding-left: 15px;padding-right: 15px;text-align: center;font-size: 50px;line-height: 70px;color: #060C3B;margin-top: 80px;}.top-collection-header h2 {max-width: 595px;margin-left: auto;margin-right: auto;font-family: DM Serif Display;}'
        ]));


        $this->insertThemeCustomization(3, 'category_carousel', 'Trending Categories', 3, json_encode([
            'filters' => [
                'trending' => true,
                'sort' => 'asc',
                'limit' => 10,
            ],
        ]));


//        DB::table('theme_customizations')
//            ->insert([
//                [
//                    'id' => 1,
//                    'type' => 'image_carousel',
//                    'name' => 'Image Carousel',
//                    'sort_order' => 1,
//                    'status' => 1,
//                ], [
//                    'id' => 2,
//                    'type' => 'static_content',
//                    'name' => 'Offer Information',
//                    'sort_order' => 2,
//                    'status' => 1,
//                ], [
//                    'id' => 3,
//                    'type' => 'category_carousel',
//                    'name' => 'Categories Collections',
//                    'sort_order' => 3,
//                    'status' => 1,
//                ], [
//                    'id' => 4,
//                    'type' => 'product_carousel',
//                    'name' => 'New Products',
//                    'sort_order' => 4,
//                    'status' => 1,
//                ], [
//                    'id' => 5,
//                    'type' => 'static_content',
//                    'name' => 'Top Collections',
//                    'sort_order' => 5,
//                    'status' => 1,
//                ], [
//                    'id' => 6,
//                    'type' => 'static_content',
//                    'name' => 'Bold Collections',
//                    'sort_order' => 6,
//                    'status' => 1,
//                ], [
//                    'id' => 7,
//                    'type' => 'product_carousel',
//                    'name' => 'Featured Collections',
//                    'sort_order' => 7,
//                    'status' => 1,
//                ], [
//                    'id' => 8,
//                    'type' => 'static_content',
//                    'name' => 'Game Container',
//                    'sort_order' => 8,
//                    'status' => 1,
//                ], [
//                    'id' => 9,
//                    'type' => 'product_carousel',
//                    'name' => 'All Products',
//                    'sort_order' => 9,
//                    'status' => 1,
//                ], [
//                    'id' => 10,
//                    'type' => 'static_content',
//                    'name' => 'Bold Collections',
//                    'sort_order' => 10,
//                    'status' => 1,
//                ], [
//                    'id' => 11,
//                    'type' => 'footer_links',
//                    'name' => 'Footer Links',
//                    'sort_order' => 11,
//                    'status' => 1,
//                ],
//            ]);
    }
}
