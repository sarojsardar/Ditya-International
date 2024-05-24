<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategories(){
        $categories = Category::get();
        $categoriesResource = CategoryResource::collection($categories);
        return response()->json(['categories' => $categoriesResource]);
    }
}
