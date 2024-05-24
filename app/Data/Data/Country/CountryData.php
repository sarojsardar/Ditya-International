<?php
namespace App\Data\Country;
use App\Models\Country;

class CountryData{

    public function countryList(){
        return Country::orderBy('name', 'asc')->get();
    }

}