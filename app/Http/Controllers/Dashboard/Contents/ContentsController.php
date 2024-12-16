<?php

namespace App\Http\Controllers\Dashboard\Contents;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Contents\CreateContentsRequest;
use App\Http\Requests\Dashboard\Contents\UpdateContentsRequest;
// Models
use App\Models\Content as ContentModel;
class ContentsController extends Controller
{
    protected $fileName = "contents";
    protected $controllerName = "Contents";
    protected $routeName = "contents";


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
        $lists = ContentModel::latest()->paginate();
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

    public function store(CreateContentsRequest $request) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload(request("image"),$this->fileName);
        }
        ContentModel::create($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,ContentModel $content) {
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

    public function update(UpdateContentsRequest $request,ContentModel $content) {
        $request = $request->all();
        if(request()->has("image")) {
            $request["image"] = imageUpload(request("image"),$this->fileName);
        }
        $content->update($request);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,ContentModel $content) {
        $content->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }
}
