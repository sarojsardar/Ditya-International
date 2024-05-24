<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SplashResource;
use App\Models\Splash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SplashController extends Controller
{
    public function getFirstSplash()
    {
        $splash = Splash::latest()->take(1)->get();

        $this->data =  SplashResource::collection($splash);
        return response()->json([
            'data' => $this->data,
            'message' => 'Splash List'
        ]);
    }
}
