<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_settings')->insert([
            'id' => 1,
            'site_name' => 'Ditya International Private Limited',
            'site_logo' => '',
            'site_logo_sm' => '',
            'location' => 'Sinamangal-9, Manpower Bazar, Kathmandu, Nepal',
            'map' => NULL,
            'description' => NULL,
            'terms_and_condition' => NULL,
            'contact' => '+977 1-5912818',
            'fb_link' => 'https://www.facebook.com/dityainternational/',
            'insta_link' => NULL,
            'official_email' => 'info@dityainternational.com.np',
            'created_at' => '2023-07-20 06:15:25',
            'updated_at' => '2023-08-16 11:20:32',
            'tiktok_link' => NULL,
            'whatsapp' => '+97715912818',
            'privacy_and_policy' => NULL,
        ]);
    }
}
