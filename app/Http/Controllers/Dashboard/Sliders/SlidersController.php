<?php

namespace App\Http\Controllers\Dashboard\Sliders;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Sliders\CreateSlidersRequest;
use App\Http\Requests\Dashboard\Sliders\UpdateSlidersRequest;
// Models
use App\Models\Slider as SliderModel;
use App\Models\User;

class SlidersController extends Controller
{
    protected $fileName = "sliders";
    protected $controllerName = "Sliders";
    protected $routeName = "sliders";

    protected $userType = User::TYPE_PROVIDER;


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
        $lists = SliderModel::latest()->paginate();
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
        $providers = User::where('user_type',$this->userType)->get();$providers = User::where('user_type',$this->userType)->get();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CreateSlidersRequest $request) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        SliderModel::create($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,SliderModel $slider) {
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
        $providers = User::where('user_type',$this->userType)->get();
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(UpdateSlidersRequest $request,SliderModel $slider) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        $slider->update($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,SliderModel $slider) {
        $slider->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }

}
