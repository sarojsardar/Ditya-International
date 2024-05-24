<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Language::truncate();

        Language::create([
            "name" => "english",
            "slug" => "english"
        ]);
        Language::create([
            "name" => "hindi",
            "slug" => "hindi"
        ]);
        Language::create([
            "name" => "malay",
            "slug" => "malay"
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
