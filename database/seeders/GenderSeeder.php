<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Gender::truncate();

        Gender::create([
            "name" => "male",
            "slug" => "male"
        ]);
        Gender::create([
            "name" => "female",
            "slug" => "female"
        ]);

        Gender::create([
            "name" => "other",
            "slug" => "other"
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
