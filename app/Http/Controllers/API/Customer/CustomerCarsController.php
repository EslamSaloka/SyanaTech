<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Car\CarRequest;
// Model
use App\Models\User;
use App\Models\Car;
// Helpers
use Sunrise\Vin\Vin;
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Cars\CarsResource;

class CustomerCarsController extends Controller
{

    public function index() {
        $cars = $this->getCars();
        return (new API)->isOk(__("Cars Lists"))
            ->setData(CarsResource::collection($cars))
            ->build();
    }

    public function store(CarRequest $request) {
        if(request()->has("vin") && request("vin") != '') {
            $check = Car::where('vin',$request->vin)->first();
            if(!is_null($check)) {
                return (new API)->isError(__("Oops, This Vin Number Used Before"))->build();
            }
        }
        $checkVin = getVinInformation($request->vin ?? '');
        if($checkVin == 0) {
            return (new API)->isError(__("Oops, This Vin Is Not True"))->build();
        }
        // $vin = new Vin($request->vin);
        // $vin = $vin->toArray();
        $car = Car::create([
            'car_country_factory_id'        => $request->car_country_factory_id,
            'color_id'                      => $request->color_id,
            'customer_id'                   => \Auth::user()->id,
            "vin"                           => $request->vin ?? '',
            "vds"                           => $checkVin["model"],
            "region"                        => "",
            "country"                       => "",
            "manufacturer"                  => $checkVin['make'],
            "modelYear"                     => $checkVin['year'],
        ]);
        return (new API)->isOk(__("Your Car Has Been Created"))
            ->setData(new CarsResource($car))
            ->build();
    }

    public function update(CarRequest $request,Car $car) {
        if(request()->has("vin") && request("vin") != '') {
            $check = Car::where('vin',$request->vin)->first();
            if(!is_null($check)) {
                if($check->customer_id != \Auth::user()->id) {
                    return (new API)->isError(__("Oops, This Vin Number Used Before"))->build();
                }
            }
        }
        $checkVin = getVinInformation($request->vin ?? '');
        if($checkVin == 0) {
            return (new API)->isError(__("Oops, This Vin Is Not True"))->build();
        }
        // $vin = new Vin($request->vin);
        // $vin = $vin->toArray();
        $car->update([
            'car_country_factory_id'        => $request->car_country_factory_id,
            'color_id'                      => $request->color_id,
            'customer_id'                   => \Auth::user()->id,
            "vin"                           => $request->vin ??'',
            "vds"                           => $checkVin["model"],
            "region"                        => "",
            "country"                       => "",
            "manufacturer"                  => $checkVin['make'],
            "modelYear"                     => $checkVin['year'],
        ]);
        return (new API)->isOk(__("Your Car Has Been Created"))
            ->setData(new CarsResource($car))
            ->build();
    }

    public function show(Car $car) {
        return (new API)->isOk(__("Car information"))
            ->setData(new CarsResource($car))
            ->build();
    }

    public function destroy(Car $car) {
        if($car->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Permeation To Access This Car"))->build();
        }
        $car->delete();
        return (new API)->isOk(__("Your Car Has Been Deleted"))->build();
    }

    private function getCars() {
        return \Auth::user()->cars()->get();
    }

}
