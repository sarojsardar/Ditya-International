<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function allCountries()
    {
        $countries = Country::get();
        $countriesResource = CountryResource::collection($countries);
        return response()->json(['countries' => $countriesResource]);
    }   //end of method

}
