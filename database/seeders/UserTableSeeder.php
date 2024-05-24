<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();
        $superAdmin = User::create([
            'username' => 'DityaMain',
            'email' => 'info@dityainternational.com',
            'password' => Hash::make('Admin@2023'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $superAdmin->syncRoles(['CEO']);

        Schema::enableForeignKeyConstraints();
    }
}
