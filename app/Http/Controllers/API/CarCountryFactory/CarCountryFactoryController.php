<?php

namespace App\Http\Controllers\API\CarCountryFactory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
// Models
use App\Models\CarCountryFactory as CarCountryFactoryModels;
// Resources
use App\Http\Resources\API\CarCountryFactory\CarCountryFactoryResource;

class CarCountryFactoryController extends Controller
{
    public function index (Request $request) {
        $car_country_factories = CarCountryFactoryModels::all();
        return (new API)
            ->isOk(__("CarCountryFactory lists"))
            ->setData(CarCountryFactoryResource::collection($car_country_factories))
            ->build();
    }
}
