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

        $this->insertThemeCustomization('image_carousel', 'Top Banner', json_encode([
            'images' => [
                ['link' => '', 'image' => 'storage/theme/1/1.webp'], ['link' => '', 'image' => 'storage/theme/1/2.webp',]
            ],
        ]));

        $this->insertThemeCustomization('static_content', 'Trending Categories Label', json_encode([
            'html' => '<div class="top-collection-container"><div class="top-collection-header"><h2>Trending Categories</h2></div></div>',
            'css' => '.top-collection-header {padding-left: 15px;padding-right: 15px;text-align: center;font-size: 50px;line-height: 70px;color: #060C3B;margin-top: 80px;}.top-collection-header h2 {max-width: 595px;margin-left: auto;margin-right: auto;font-family: DM Serif Display;}'
        ]));


        $this->insertThemeCustomization('category_carousel', 'Trending Categories', json_encode([
            'filters' => [
                'trending' => true,
                'sort' => 'asc',
                'limit' => 10,
            ],
        ]));

        $this->insertThemeCustomization('static_content', 'Smart Watches', json_encode([
                "css" => ".section-gap {margin-top:80px}.direction-ltr {direction:ltr}.direction-rtl {direction:rtl}.inline-col-wrapper {display:grid;grid-template-columns:auto 1fr;grid-gap:60px;align-items:center;text-align: right}.inline-col-wrapper .inline-col-image-wrapper {overflow:hidden}.inline-col-wrapper .inline-col-image-wrapper img {max-width:100%;height:auto;border-radius:16px;text-indent:-9999px}.inline-col-wrapper .inline-col-content-wrapper {display:flex;flex-wrap:wrap;gap:20px;max-width:464px;justify-content: flex-end}.inline-col-wrapper .inline-col-content-wrapper .inline-col-title {max-width:442px;font-size:60px;font-weight:400;color:#060c3b;line-height:70px;font-family:DM Serif Display;margin:0}.inline-col-wrapper .inline-col-content-wrapper .inline-col-description {margin:0;font-size:18px;color:#6e6e6e;font-family:Poppins}@media (max-width:991px) {.inline-col-wrapper {grid-template-columns:1fr;grid-gap:16px}.inline-col-wrapper .inline-col-content-wrapper {gap:10px}}@media (max-width:525px) {.inline-col-wrapper .inline-col-content-wrapper .inline-col-title {font-size:30px;line-height:normal}}",
                "html" => '<div class="container section-gap"><div class="inline-col-wrapper"><div class="inline-col-content-wrapper"><h2 class="inline-col-title sn-color-main"> Unleash the power of a smartwatch on your wrist</h2> <p class="inline-col-description">Stay connected, monitor your health, and elevate your everyday with a timepiece thats more than just a watch.</p><button class="primary-button sn-background-main sn-border-none">View All</button></div><div class="inline-col-image-wrapper"><img src="" data-src="storage/theme/smart-watch-collection.jpg" class="lazy" width="632" height="510" alt=""></div></div></div>'
            ]
        ));

        $this->insertThemeCustomization('static_content', 'Banner 1', json_encode([
            'css' => "",
            'html' => '<div class="container section-gap"><img src="storage/theme/banner 1.jpg"></div>'
        ]));

        $this->insertThemeCustomization('product_carousel', 'Newest to our collection', json_encode([
                "title" => "Newest to our collection",
                "filters" => [
                    "sort" => "created_at-desc",
                    "limit" => "12"
                ]
            ]
        ));

        $this->insertThemeCustomization('static_content', 'Banner 2', json_encode([
            'css' => "",
            'html' => '<div class="container section-gap"><img src="storage/theme/banner 2.jpg"></div>'
        ]));

        $this->insertThemeCustomization('product_carousel', 'Cheapest in Fashion', json_encode([
                "title" => "Cheapest in Fashion",
                "filters" => [
                    "sort" => "created_at-desc",
                    "category_id" => "4",
                    "limit" => "12"
                ]
            ]
        ));


        $this->insertThemeCustomization('static_content', 'Winter Collection', json_encode([
            "css" => ".section-gap {margin-top:80px}.direction-ltr {direction:ltr}.direction-rtl {direction:rtl}.inline-col-wrapper {display:grid;grid-template-columns:auto 1fr;grid-gap:60px;align-items:center}.inline-col-wrapper .inline-col-image-wrapper {overflow:hidden}.inline-col-wrapper .inline-col-image-wrapper img {max-width:100%;height:auto;border-radius:16px;text-indent:-9999px}.inline-col-wrapper .inline-col-content-wrapper {display:flex;flex-wrap:wrap;gap:20px;max-width:464px}.inline-col-wrapper .inline-col-content-wrapper .inline-col-title {max-width:442px;font-size:60px;font-weight:400;color:#060c3b;line-height:70px;font-family:DM Serif Display;margin:0}.inline-col-wrapper .inline-col-content-wrapper .inline-col-description {margin:0;font-size:18px;color:#6e6e6e;font-family:Poppins}@media (max-width:991px) {.inline-col-wrapper {grid-template-columns:1fr;grid-gap:16px}.inline-col-wrapper .inline-col-content-wrapper {gap:10px}}@media (max-width:525px) {.inline-col-wrapper .inline-col-content-wrapper .inline-col-title {font-size:30px;line-height:normal}}",
            "html" => '<div class="container section-gap"><div class="inline-col-wrapper"><div class="inline-col-image-wrapper"><img src="" data-src="storage/theme/winter-styles.jpg" class="lazy" width="632" height="510" alt=""></div><div class="inline-col-content-wrapper"><h2 class="inline-col-title sn-color-main"> Stay Comfy and Stylish in Our Winter Collection </h2> <p class="inline-col-description">Combat the winter chill with our stylish and comfortable winter collection.</p><button class="primary-button sn-background-main sn-border-none">View All</button></div></div></div>'
        ]));

        $this->insertThemeCustomization('static_content', 'Banner 3', json_encode([
            'css' => "",
            'html' => '<div class="container section-gap"><img src="storage/theme/banner 3.jpg"></div>'
        ]));

        $this->insertThemeCustomization('footer_links', 'footer', json_encode([
            'column_1' => [
                [
                    'url' => '/page/about-us',
                    'title' => 'About Us',
                    'sort_order' => 1,
                ], [
                    'url' => '/page/contact-us',
                    'title' => 'Contact Us',
                    'sort_order' => 2,
                ], [
                    'url' => '/page/customer-service',
                    'title' => 'Customer Service',
                    'sort_order' => 3,
                ], [
                    'url' => '/page/whats-new',
                    'title' => 'What\'s new',
                    'sort_order' => 4,
                ], [
                    'url' => '/page/terms-of-use',
                    'title' => 'Terms of use',
                    'sort_order' => 5,
                ], [
                    'url' => '/page/terms-conditions',
                    'title' => 'Terms & Conditions',
                    'sort_order' => 6,
                ]
            ],

            'column_2' => [
                [
                    'url' => '/page/privacy-policy',
                    'title' => 'Privacy Policy',
                    'sort_order' => 1,
                ], [
                    'url' => '/page/payment-policy',
                    'title' => 'Payment Policy',
                    'sort_order' => 2,
                ], [
                    'url' => '/page/shipping-policy',
                    'title' => 'Shipping Policy',
                    'sort_order' => 3,
                ], [
                    'url' => '/page/refund-policy',
                    'title' => 'Refund Policy',
                    'sort_order' => 4,
                ], [
                    'url' => '/page/return-policy',
                    'title' => 'Return Policy',
                    'sort_order' => 5,
                ],
            ],
        ]));

    }
}
