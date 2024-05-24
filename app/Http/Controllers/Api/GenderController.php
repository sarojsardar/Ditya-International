<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function allGenders(){
        $genders = Gender::get();
        $gendersResource = GenderResource::collection($genders);
        return response()->json(['genders' => $gendersResource]);
    }
}
