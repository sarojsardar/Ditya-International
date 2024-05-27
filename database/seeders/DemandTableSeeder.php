<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDemand;
use App\Models\Language;
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
        DB::table('company_demand_language')->truncate();
        $languages = Language::all();
        $companies = Company::all();
        foreach($companies as $index=>$company){
            if($index <= 4){
                $demandCode = IdGenerator::generate(['table' => 'company_demands', 'field' => 'demand_code', 'length' => 10, 'prefix' =>'DMD-']);
                $demandData = [
                    'company_id'=>$company->id,
                    'demand_code'=>$demandCode,
                    'quota'=>$faker->numberBetween(11, 99),
                    'gender'=>'male',
                    'age_from'=>20,
                    'age_to'=>40,
                    'height'=>5.3,
                    'weight'=>55,
                    'experience_year'=>0,
                    'education'=>'see',
                    'edu_level'=>1,
                    'demand_letter'=>$faker->imageUrl(),
                    'is_new'=>true,
                    'status'=>'Pending',
                ];

                $companyDemand = CompanyDemand::create($demandData);
                foreach($languages as $language){
                    DB::table('company_demand_language')->insert([
                        'company_demand_id'=>$companyDemand->id,
                        'language_id'=>$language->id,
                    ]);
                }
            }

            if($index > 4){
                $demandCode = IdGenerator::generate(['table' => 'company_demands', 'field' => 'demand_code', 'length' => 10, 'prefix' =>'DMD-']);
                $demandData = [
                    'company_id'=>$company->id,
                    'demand_code'=>$demandCode,
                    'quota'=>$faker->numberBetween(11, 99),
                    'gender'=>'female',
                    'age_from'=>20,
                    'age_to'=>40,
                    'height'=>5.3,
                    'weight'=>55,
                    'experience_year'=>0,
                    'education'=>'see',
                    'edu_level'=>1,
                    'demand_letter'=>$faker->imageUrl(),
                    'is_new'=>true,
                    'status'=>'Pending',
                ];
                $companyDemand = CompanyDemand::create($demandData);

                foreach($languages as $language){
                    DB::table('company_demand_language')->insert([
                        'company_demand_id'=>$companyDemand->id,
                        'language_id'=>$language->id,
                    ]);
                }
            }

           
        }
        Schema::enableForeignKeyConstraints();
    }
}
