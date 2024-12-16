<?php

namespace App\Http\Controllers\Dashboard\Refusals;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Refusals\RefusalsRequest;
// Models
use App\Models\Refusal as RefusalModel;

class RefusalsController extends Controller
{
    protected $fileName = "refusals";
    protected $controllerName = "Refusals";
    protected $routeName = "refusals";


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
        $lists = RefusalModel::latest()->paginate();
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

    public function store(RefusalsRequest $request) {
        RefusalModel::create($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,RefusalModel $refusal) {
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

    public function update(RefusalsRequest $request,RefusalModel $refusal) {
        $refusal->update($request->all());
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,RefusalModel $refusal) {
        $refusal->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
