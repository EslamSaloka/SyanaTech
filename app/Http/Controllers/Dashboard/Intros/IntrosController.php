<?php

namespace App\Http\Controllers\Dashboard\Intros;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Intros\CreateIntrosRequest;
use App\Http\Requests\Dashboard\Intros\UpdateIntrosRequest;
// Models
use App\Models\Intro as IntroModel;
class IntrosController extends Controller
{
    protected $fileName = "intros";
    protected $controllerName = "Intros";
    protected $routeName = "intros";


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
        $lists = IntroModel::latest()->paginate();
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

    public function store(CreateIntrosRequest $request) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        IntroModel::create($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,IntroModel $intro) {
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

    public function update(UpdateIntrosRequest $request,IntroModel $intro) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        $intro->update($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,IntroModel $intro) {
        $intro->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
