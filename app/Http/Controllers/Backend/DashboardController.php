<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        
        // dd(auth()->user(), auth()->user()->companyInfo);
        return view('backend.pages.dashboards.ceo-dashboard');
    }



}
