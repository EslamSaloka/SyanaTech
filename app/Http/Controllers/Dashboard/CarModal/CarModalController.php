<?php

namespace App\Http\Controllers\Dashboard\CarModal;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CarFactories\CarFactoriesRequest;
// Models
use App\Models\CarModal as CarModalModel;

class CarModalController extends Controller
{
    protected $fileName = "car_modals";
    protected $controllerName = "Car Modal";
    protected $routeName = "car_modals";


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
        $lists = CarModalModel::where("parent_id",0)->paginate();
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
        $items = CarModalModel::where("parent_id",0)->latest()->get();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CarFactoriesRequest $request) {
        CarModalModel::create($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function show(CarModalModel $car_modal) {
        $breadcrumb = [
            'title' =>  __("$this->controllerName List"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("$car_modal->name"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $lists = CarModalModel::where("parent_id",$car_modal->id)->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function edit(Request $request,CarModalModel $car_modal) {
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
        $items = CarModalModel::where("parent_id",0)->latest()->get();
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(CarFactoriesRequest $request,CarModalModel $car_modal) {
        $car_modal->update($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

}
