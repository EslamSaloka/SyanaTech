<?php

namespace App\Http\Controllers\API\Sliders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\Slider;
// Resources
use App\Http\Resources\API\Sliders\SlidersResource;

class SlidersController extends Controller
{
    public function index (Request $request) {
        $sliders = Slider::all();
        return (new API)
            ->isOk(__("Sliders lists"))
            ->setData(SlidersResource::collection($sliders))
            ->build();
    }
}
