<?php

namespace Webkul\CMS\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CMSPagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cms_pages')->delete();
        DB::table('cms_page_translations')->delete();

        DB::table('cms_pages')->insert([
            [
                'id'         => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id'         => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'id'         => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
        ]);

        DB::table('cms_page_translations')->insert([
            [
                'locale'           => 'ar',
                'cms_page_id'      => 1,
                'url_key'          => 'about-us',
                'html_content' => '',
                'page_title'       => 'عنا',
                'meta_title'       => 'عنا',
                'meta_description' => '',
                'meta_keywords'    => 'عنا',
            ], [
                'locale'           => 'ar',
                'cms_page_id'      => 2,
                'url_key'          => 'privacy-policy',
                'html_content' => '',
                'page_title'       => 'سياسة الخصوصية',
                'meta_title'       => 'سياسة الخصوصية',
                'meta_description' => '',
                'meta_keywords'    => 'سياسة, الخصوصية',
            ], [
                'locale'           => 'ar',
                'cms_page_id'      => 3,
                'url_key'          => 'terms-of-use',
                'html_content' => '',
                'page_title'       => 'سياسة الاستخدام',
                'meta_title'       => 'سياسة الاستخدام',
                'meta_description' => '',
                'meta_keywords'    => 'سياسة, الاستخدام',
            ], 
        ]);
    }
}