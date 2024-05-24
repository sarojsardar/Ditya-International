<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Category::truncate();

        Category::create([
            "name" => "furniture",
            "slug" => "furniture"
        ]);
        Category::create([
            "name" => "factory_worker",
            "slug" => "factory-worker"
        ]);
        Category::create([
            "name" => "labour",
            "slug" => "labour"
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
