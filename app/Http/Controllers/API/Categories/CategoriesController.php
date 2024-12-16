<?php

namespace App\Http\Controllers\API\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Category;
// Resources
use App\Http\Resources\API\Categories\CategoriesResource;

class CategoriesController extends Controller
{
    public function index (Request $request) {
        $categories = Category::all();
        return (new API)
            ->isOk(__("Categories lists"))
            ->setData(CategoriesResource::collection($categories))
            ->build();
    }
}
