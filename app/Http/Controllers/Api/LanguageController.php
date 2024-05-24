<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function allLanguages(){
            $languages = Language::get();
            $languagesResource = LanguageResource::collection($languages);
            return response()->json(['languages' => $languagesResource]);
    }
}
