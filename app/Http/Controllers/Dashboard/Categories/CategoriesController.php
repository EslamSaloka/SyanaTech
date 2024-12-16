<?php

namespace App\Http\Controllers\Dashboard\Categories;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Categories\CreateCategoriesRequest;
use App\Http\Requests\Dashboard\Categories\UpdateCategoriesRequest;
// Models
use App\Models\Category as CategoryModel;
class CategoriesController extends Controller
{
    protected $fileName = "categories";
    protected $controllerName = "Categories";
    protected $routeName = "categories";


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
        $lists = CategoryModel::latest()->paginate();
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

    public function store(CreateCategoriesRequest $request) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        CategoryModel::create($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,CategoryModel $category) {
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

    public function update(UpdateCategoriesRequest $request,CategoryModel $category) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload($request["image"],$this->fileName);
        }
        $category->update($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,CategoryModel $category) {
        $category->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
