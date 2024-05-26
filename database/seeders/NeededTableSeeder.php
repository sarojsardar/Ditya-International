<?php

namespace Database\Seeders;

use App\Enum\UserTypes;
use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\Company;
use App\Models\EducationalDocument;
use App\Models\EducationType;
use App\Models\Language;
use App\Models\LanguageDetail;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserInformation;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class NeededTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        Schema::disableForeignKeyConstraints();

        // for the ceo
        User::truncate();
        $superAdmin = User::create([
            'username' => 'DityaMain',
            'email' => 'info@dityainternational.com',
            'password' => Hash::make('Admin@2023'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $superAdmin->syncRoles(['CEO']);


       
        $user = User::create([
            'username' => 'hrditya',
            'email' => 'hr@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['HR']);


        $user = User::create([
            'username' => 'proditya',
            'email' => 'pro@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['PRO']);


      
        $user = User::create([
            'username' => 'receptionistditya',
            'email' => 'receptionist@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['Receptionist']);

      
        $user = User::create([
            'username' => 'documentditya',
            'email' => 'document@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['Document-Officer']);


      
        $user = User::create([
            'username' => 'managerditya',
            'email' => 'manager@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['Manager']);


       
        $user = User::create([
            'username' => 'medicalditya',
            'email' => 'medical@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['Medical-Officer']);

      
        $user = User::create([
            'username' => 'accountantditya',
            'email' => 'accountant@dityainternational.com',
            'password' => Hash::make('password'),
            'mobile_no' => '',
            'status' => 1,

        ]);
        $user->syncRoles(['Accountant']);


        // for the company/client
        DB::table('companies')->truncate();
        DB::table('category_company')->truncate();

        for($i=1; $i<=10; $i++){
            $email = $faker->email();
            $companyUserData  = [
                'username'=>$email,
                'email'=>$email,
                'user_type'=>UserTypes::COMPANY,
                'password'=>Hash::make('password'),
                'mobile_no'=>$faker->numberBetween(1111111111, 9999999999),
                'code'=>null,
                'email_verified_at'=>Carbon::now(),
                'status'=>1,
                'demand_status'=>'New',
                'reference_id'=>null,
            ];
            $user = User::create($companyUserData);
            $user->syncRoles(['Company']);
            $companyData = [
                'user_id'=>$user->id,
                'name'=>$faker->name(),
                'address'=>$faker->address(),
                'logo'=>$faker->imageUrl(),
                'country'=>133,
            ];
            $company = Company::create($companyData);
            DB::table('category_company')->insert([
                'user_id'=>$user->id,
                'company_id'=>$company->id,
                'category_id'=>1,
            ]);
        }






        DB::table('user_details')->truncate();
        // for the candidate
        for($i=1; $i<=10; $i++){
            $email = $faker->email();
            $candidateUserData  = [
                'username'=>$email,
                'email'=>$email,
                'user_type'=>UserTypes::CANDIDATE,
                'password'=>Hash::make('password'),
                'mobile_no'=>$faker->numberBetween(1111111111, 9999999999),
                'code'=>null,
                'email_verified_at'=>Carbon::now(),
                'status'=>1,
                'demand_status'=>'New',
                'reference_id'=>null,
            ];
            $user = User::create($candidateUserData);

            $userDetails = [
                'user_id'=>$user->id,
                'full_name'=>$faker->name(),
                'permanent_address'=>$faker->address(),
                'temporary_address'=>$faker->address(),
                'father_name'=>$faker->name(),
                'mother_name'=>$faker->name(),
                'marital_status'=>'Unmarried',
                'spouse_name'=>null,
                'gender'=>'male',
                'height'=>'5.3',
                'weight'=>$faker->numberBetween(55, 99),
                'dob'=>Carbon::now()->subYear(25),
                'age'=>25,
                'has_relatives_in_malaysia'=>$faker->boolean(),
                'has_been_in_accident'=>$faker->boolean(),
            ];
            $userDetails = UserDetail::create($userDetails);
        }




        for($i=1; $i<=10; $i++){
            $email = $faker->email();
            $candidateUserData  = [
                'username'=>$email,
                'email'=>$email,
                'user_type'=>UserTypes::CANDIDATE,
                'password'=>Hash::make('password'),
                'mobile_no'=>$faker->numberBetween(1111111111, 9999999999),
                'code'=>null,
                'email_verified_at'=>Carbon::now(),
                'status'=>1,
                'demand_status'=>'New',
                'reference_id'=>null,
            ];
            $user = User::create($candidateUserData);

            $userDetails = [
                'user_id'=>$user->id,
                'full_name'=>$faker->name(),
                'permanent_address'=>$faker->address(),
                'temporary_address'=>$faker->address(),
                'father_name'=>$faker->name(),
                'mother_name'=>$faker->name(),
                'marital_status'=>'Married',
                'spouse_name'=>null,
                'gender'=>'female',
                'height'=>'5.3',
                'weight'=>$faker->numberBetween(55, 99),
                'dob'=>Carbon::now()->subYear(25),
                'age'=>25,
                'has_relatives_in_malaysia'=>$faker->boolean(),
                'has_been_in_accident'=>$faker->boolean(),
            ];
            $userDetails = UserDetail::create($userDetails);

            DB::table('user_information')->truncate();
            $userInfo = [
                'user_id'=>$user->id,
                'first_name'=>$faker->firstName(),
                'last_name'=>$faker->lastName(),
                'middle_name'=>null,
                'contact'=>$faker->numberBetween(111111111, 999989999),
                'full_address'=>$faker->address(),
                'profile_picture'=>$faker->imageUrl(),
            ];
            $userInfo =  UserInformation::create($userInfo);
            
            DB::table('language_details')->truncate();
            $languages = Language::all();
            foreach($languages as $language){
                $languageData = [
                    'user_id'=>$user->id,
                    'language_name'=>$language->id,
                ];
                $userLanguage = LanguageDetail::create($languageData);
            }

            DB::table('category_details')->truncate();
            $categories = Category::all();
            foreach($categories as $category){
                $categorydata = [
                    'user_id'=>$user->id,
                    'category_id'=>$category->id,
                ];
                $categoryDetail = CategoryDetail::create($categorydata);
            }


            DB::table('educational_documents')->truncate();
            $educationtypes = EducationType::all();
            foreach($educationtypes as $type){
                $educationdata = [
                    'user_id'=>$user->id,
                    'edu_doc'=>$faker->imageUrl(),
                    'level'=>$type->name,
                    'edu_level'=>$type->edu_level,
                    'school_college_name'=>$faker->name(),
                    'pass_year'=>Carbon::now()->subYear(5),
                ];
                $educationDetail = EducationalDocument::create($educationdata);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
