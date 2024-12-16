<?php

namespace App\Http\Controllers\API\Areas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Area;
// Resources
use App\Http\Resources\API\Areas\AreasResource;

class AreasController extends Controller
{
    public function index (Request $request) {
        $areas = Area::where('parent',0)->paginate();
        return (new API)
            ->isOk(__("Areas lists"))
            ->setData(AreasResource::collection($areas))
            ->addAttribute('paginate',api_model_set_paginate($areas))
            ->build();
    }

    public function show(Area $area) {
        if($area->parent != 0) {
            return (new API)->isError(__("This Area Not A Parent"))->build();
        }
        $areas = Area::where('parent',$area->id)->paginate();
        return (new API)
            ->isOk(__("Cities lists"))
            ->setData(AreasResource::collection($areas))
            ->addAttribute('paginate',api_model_set_paginate($areas))
            ->build();
    }
}
