<?php

namespace App\Http\Controllers\Dashboard\Admins;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admins\CreateAdminsRequest;
use App\Http\Requests\Dashboard\Admins\UpdateAdminsRequest;
// Models
use App\Models\User;

class AdminsController extends Controller
{
    protected $fileName = "admins";
    protected $controllerName = "Admins";
    protected $routeName = "admins";
    protected $userType = User::TYPE_ADMIN;

    public function index() {
        $breadcrumb = [
            'title' =>  __("$this->controllerName list"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName list"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $lists = User::where('user_type',$this->userType);
        if(request()->has("name") && request("name") != '') {
            $lists = $lists->where('first_name','like','%'.request('name').'%')->orWhere('email','like','%'.request('name').'%')->where('user_type',$this->userType);
        }
        $lists = $lists->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("$this->controllerName list"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName list"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("Create new admin"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CreateAdminsRequest $request) {
        User::create(silentFact($request,["avatar"],$this->fileName,["user_type"=>$this->userType]));
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,User $admin) {
        if($admin->user_type != $this->userType) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("$this->controllerName list"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName list"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("Edit admin"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(UpdateAdminsRequest $request,User $admin) {
        if($admin->user_type != $this->userType) {
            abort(404);
        }
        $admin->update(silentFact($request,["avatar"],$this->fileName));
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,User $admin) {
        if($admin->user_type != $this->userType) {
            abort(404);
        }
        if($admin->super_admin == 1) {
            abort(401);
        }
        $admin->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }

}
