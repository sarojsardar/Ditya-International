<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use App\Models\EducationType;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function allEducations(){
        $educations = EducationType::get();
        $educationResource = EducationResource::collection($educations);
        return response()->json(['educations' => $educationResource]);
    }
}
