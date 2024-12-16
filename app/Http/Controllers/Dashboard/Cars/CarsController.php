<?php

namespace App\Http\Controllers\Dashboard\Cars;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Cars\CarsRequest;
// Models
use App\Models\Car as CarModel;
use App\Models\Color;
use App\Models\CarCountryFactory;
use App\Models\User;
// Helpers
use Sunrise\Vin\Vin;
class CarsController extends Controller
{
    protected $fileName = "cars";
    protected $controllerName = "Cars";
    protected $routeName = "cars";


    public function index() {
        $breadcrumb = [
            'title' =>  __("$this->controllerName List"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $lists = CarModel::latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("$this->controllerName List"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("Create New $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $colors    = Color::all();
        $factories = CarCountryFactory::all();
        $customers = User::where('user_type',User::TYPE_CUSTOMER)->get();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CarsRequest $request) {
        $vin = CarModel::where('vin',$request->vin)->first();
        if($vin) {
            return redirect()->route("admin.$this->fileName.index")->withInput()->withErrors(["vin"=>__("This VIN Number Is Used Before")]);
        }
        $checkVin = getVinInformation($request->vin);
        if($checkVin) {
            return redirect()->route("admin.$this->fileName.index")->withInput()->withErrors(["vin"=>__("This VIN Number Is Not True")]);
        }
        // $vin = new Vin($request->vin);
        // $vin = $vin->toArray();
        CarModel::create([
            'car_country_factory_id'        => $request->car_country_factory_id,
            'color_id'                      => $request->color_id,
            'customer_id'                   => $request->customer_id,
            "vin"                           => $request->vin,
            "vds"                           => $checkVin["model"],
            "region"                        => "",
            "country"                       => "",
            "manufacturer"                  => $checkVin['make'],
            "modelYear"                     => $checkVin['year'],
        ]);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }
    
    public function destroy(Request $request,CarModel $car) {
        $car->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
