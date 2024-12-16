<?php

namespace App\Http\Controllers\Dashboard\CarFactories;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CarFactories\CarFactoriesRequest;
// Models
use App\Models\CarCountryFactory as CarCountryFactoryModel;

class CarFactoriesController extends Controller
{
    protected $fileName = "car_factories";
    protected $controllerName = "Car Factories";
    protected $routeName = "car_factories";


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
        $lists = CarCountryFactoryModel::latest()->paginate();
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
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CarFactoriesRequest $request) {
        CarCountryFactoryModel::create($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,CarCountryFactoryModel $car_factory) {
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
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(CarFactoriesRequest $request,CarCountryFactoryModel $car_factory) {
        $car_factory->update($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,CarCountryFactoryModel $car_factory) {
        $car_factory->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
