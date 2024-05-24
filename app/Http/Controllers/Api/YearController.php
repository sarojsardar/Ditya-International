<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\YearResource;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    //
    public function allYears(){
        $years = Year::get();
        $yearResource = YearResource::collection($years);
        return response()->json(['years' => $yearResource ]);
    }
}
