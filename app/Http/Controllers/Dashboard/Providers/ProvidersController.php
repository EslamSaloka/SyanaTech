<?php

namespace App\Http\Controllers\Dashboard\Providers;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Providers\CreateProvidersRequest;
use App\Http\Requests\Dashboard\Providers\UpdateProvidersRequest;
// Models
use App\Models\User;
use App\Models\KnowUs;
use App\Models\Category;
use App\Models\CarCountryFactory;
use App\Models\Area;
use App\Models\Rate;

class ProvidersController extends Controller
{
    protected $fileName = "providers";
    protected $controllerName = "Providers";
    protected $routeName = "providers";
    protected $userType = User::TYPE_PROVIDER;

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
        $items      = KnowUs::all();
        $categories = Category::all();
        $factories  = CarCountryFactory::all();
        $areas      = Area::all();
        return view("admin.pages.$this->fileName.create",get_defined_vars());
    }

    public function store(CreateProvidersRequest $request) {
        $user = User::create(silentFact($request,["avatar"],$this->fileName,["user_type"=>$this->userType]));
        $user->categories()->sync($request->categories ?? []);
        $user->carCountryFactories()->sync($request->factories ?? []);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function rates(Request $request,User $provider) {
        if($provider->user_type != $this->userType) {
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
                    'title' =>  __("$this->controllerName Rates"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $lists      = $provider->rates()->latest()->paginate();
        return view("admin.pages.$this->fileName.rates",get_defined_vars());
    }

    public function edit(Request $request,User $provider) {
        if($provider->user_type != $this->userType) {
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
        $items      = KnowUs::all();
        $categories = Category::all();
        $factories  = CarCountryFactory::all();
        $areas      = Area::where('parent',0)->get();
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(UpdateProvidersRequest $request,User $provider) {
        if($provider->user_type != $this->userType) {
            abort(404);
        }
        $provider->update(silentFact($request,["avatar"],$this->fileName));
        // dd($request->all());
        $provider->categories()->sync($request->categories ?? []);
        $provider->carCountryFactories()->sync($request->factories ?? []);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function destroy(Request $request,User $provider) {
        if($provider->user_type != $this->userType) {
            abort(404);
        }
        $provider->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }

    public function approved(Request $request,User $provider) {
        if($provider->user_type != $this->userType) {
            abort(404);
        }
        $provider->update([
            "admin_approved"    => ($provider->admin_approved == 1) ? 0 : 1
        ]);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

    public function changeVat() {
        foreach(request('data') as $p=>$v) {
            User::find($p)->update([
                'vat'   => $v['v'],
                'commission_price'   => $v['c'],
            ]);
        }
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been updated'));
    }

}
