<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDemand;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DemandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        Schema::disableForeignKeyConstraints();
        DB::table('company_demands')->truncate();
        $companies = Company::all();
        foreach($companies as $index=>$company){
            if($index <= 4){
                $demandCode = IdGenerator::generate(['table' => 'company_demands', 'field' => 'demand_code', 'length' => 10, 'prefix' =>'DMD-']);
                $demandData = [
                    'company_id'=>$company->user->id,
                    'demand_code'=>$demandCode,
                    'quota'=>$faker->numberBetween(11, 99),
                    'gender'=>'male',
                    'age_from'=>20,
                    'age_to'=>40,
                    'height'=>5.3,
                    'weight'=>55,
                    'experience_year'=>0,
                    'education'=>'see',
                    'edu_level'=>10,
                    'demand_letter'=>$faker->imageUrl(),
                    'is_new'=>true,
                    'status'=>'Pending',
                ];

                CompanyDemand::create($demandData);
            }

            if($index > 4){
                $demandCode = IdGenerator::generate(['table' => 'company_demands', 'field' => 'demand_code', 'length' => 10, 'prefix' =>'DMD-']);
                $demandData = [
                    'company_id'=>$company->user->id,
                    'demand_code'=>$demandCode,
                    'quota'=>$faker->numberBetween(11, 99),
                    'gender'=>'female',
                    'age_from'=>20,
                    'age_to'=>40,
                    'height'=>5.3,
                    'weight'=>55,
                    'experience_year'=>0,
                    'education'=>'see',
                    'edu_level'=>10,
                    'demand_letter'=>$faker->imageUrl(),
                    'is_new'=>true,
                    'status'=>'Pending',
                ];
                CompanyDemand::create($demandData);
            }

           
        }
        Schema::enableForeignKeyConstraints();
    }
}
