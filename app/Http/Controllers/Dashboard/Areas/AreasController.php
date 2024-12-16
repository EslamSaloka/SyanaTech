<?php

namespace App\Http\Controllers\Dashboard\Areas;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CarFactories\CarFactoriesRequest;
// Models
use App\Models\Area as AreaModel;

class AreasController extends Controller
{
    protected $fileName = "areas";
    protected $controllerName = "Areas";
    protected $routeName = "areas";


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
        $lists = AreaModel::where("parent",0)->latest()->paginate();
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
        $items = AreaModel::where("parent",0)->latest()->get();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CarFactoriesRequest $request) {
        AreaModel::create($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function show(AreaModel $area) {
        $breadcrumb = [
            'title' =>  __("$this->controllerName List"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("$area->name"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $lists = AreaModel::where("parent",$area->id)->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function edit(Request $request,AreaModel $area) {
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
        $items = AreaModel::where("parent",0)->latest()->get();
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(CarFactoriesRequest $request,AreaModel $area) {
        $area->update($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,AreaModel $area) {
        if($area->parent == 0) {
            AreaModel::where("parent",$area->id)->delete();
        }
        $area->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
