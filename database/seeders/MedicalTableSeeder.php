<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Enum\UserTypes;
use App\Models\Medical\Medical;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MedicalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for($i=1; $i<=10; $i++){
            $medicalOfficers =DB::table('users')->where('user_type', UserTypes::MEDICAL_OFFICER)->delete();  
            for($i=1; $i<=10; $i++){
                $user = User::create([
                    'username' => $faker->userName(),
                    'email' => $faker->email(),
                    'password' => Hash::make('password'),
                    'mobile_no' => '',
                    'status' => 1,
                    'user_type'=>UserTypes::MEDICAL_OFFICER
        
                ]);
                $user->syncRoles(['Medical-Officer']);
            }
        }

        Schema::disableForeignKeyConstraints();
        DB::table('medicals')->truncate();
        for($i=1; $i<=20; $i++){
            $medicalData =[
                'name'=>$faker->name(),
                'address'=>$faker->address(),
                'status'=>true,
                'location'=>$faker->url(),
            ];
            Medical::create($medicalData);
        }

        $user = User::create([
            'username' => 'medicalditya',
            'email' => 'medical@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,
            'user_type'=>UserTypes::MEDICAL_OFFICER

        ]);
        $user->syncRoles(['Medical-Officer']);
        DB::table('medical_officer')->truncate();
        $medicalIds = Medical::all()->pluck('id')->toArray();
        $user->medicals()->attach($medicalIds);
        Schema::enableForeignKeyConstraints();
    }
}
