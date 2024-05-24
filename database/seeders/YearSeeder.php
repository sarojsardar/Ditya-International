<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Year::truncate();

        Year::create([
            "name" => "1",
            "slug" => "1"
        ]);
        Year::create([
            "name" => "2",
            "slug" => "2"
        ]);
        Year::create([
            "name" => "3",
            "slug" => "3"
        ]);
        Year::create([
            "name" => "4",
            "slug" => "4"
        ]);
        Year::create([
            "name" => "5",
            "slug" => "5"
        ]);
        Year::create([
            "name" => "6",
            "slug" => "6"
        ]);
        Year::create([
            "name" => "7",
            "slug" => "7"
        ]);
        Year::create([
            "name" => "8",
            "slug" => "8"
        ]);
        Year::create([
            "name" => "9",
            "slug" => "9"
        ]);
        Year::create([
            "name" => "10",
            "slug" => "10"
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
