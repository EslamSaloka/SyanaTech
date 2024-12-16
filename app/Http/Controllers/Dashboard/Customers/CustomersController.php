<?php

namespace App\Http\Controllers\Dashboard\Customers;

use App\Http\Controllers\Controller;
// Requests
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Customers\CreateCustomersRequest;
use App\Http\Requests\Dashboard\Customers\UpdateCustomersRequest;
// Models
use App\Models\User;
use App\Models\KnowUs;

class CustomersController extends Controller
{
    protected $fileName = "customers";
    protected $controllerName = "Customers";
    protected $routeName = "customers";
    protected $userType = User::TYPE_CUSTOMER;

    private function getUsers() {
        return User::where('user_type',$this->userType);
    }

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
        $lists = User::where('user_type',$this->userType);
        if(request()->has("name") && request("name") != '') {
            $lists = $lists->where('first_name','like','%'.request('name').'%')->orWhere('email','like','%'.request('name').'%')->where('user_type',$this->userType);
        }
        $lists = $lists->latest()->paginate();
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
        $items = KnowUs::all();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CreateCustomersRequest $request) {
        User::create(silentFact($request,["avatar"],$this->fileName,["user_type"=>$this->userType]));
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function edit(Request $request,User $customer) {
        if($customer->user_type != $this->userType) {
            abort(404);
        }
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
        $items = KnowUs::all();
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(UpdateCustomersRequest $request,User $customer) {
        if($customer->user_type != $this->userType) {
            abort(404);
        }
        $customer->update(silentFact($request,["avatar"],$this->fileName));
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,User $customer) {
        if($customer->user_type != $this->userType) {
            abort(404);
        }
        $cars = Car::where("customer_id",$customer->id)->get();
        foreach ($cars as $car){
            $car->delete();
        }
        $customer->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }

}
