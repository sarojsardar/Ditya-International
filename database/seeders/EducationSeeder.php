<?php

namespace Database\Seeders;

use App\Models\EducationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        EducationType::truncate();

        EducationType::create([
            "name" => "under_see",
            "slug" => "under_see",
            'edu_level' => 1
        ]);
        EducationType::create([
            "name" => "see",
            "slug" => "see",
            'edu_level' => 2
        ]);
        EducationType::create([
            "name" => "+2",
            "slug" => "+2",
            'edu_level' => 3
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
