<?php

namespace App\Http\Controllers\Dashboard\Dues;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
// Models
use App\Models\Dues as DuesModel;
use App\Models\Notification;

class DuesController extends Controller
{
    protected $fileName = "dues";
    protected $controllerName = "Dues";
    protected $routeName = "dues";


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
        $lists = DuesModel::where("accept",1)->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }


    public function show(DuesModel $due) {
        if($due->accept != 1) {
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
                    'title' =>  "#".$due->id,
                    'url'   =>  "#!",
                ],
            ],
        ];
        $lists = $due->items()->latest()->get();
        return view("admin.pages.$this->fileName.show",get_defined_vars());
    }

    public function accept(DuesModel $due) {
        if($due->accept == 1 || $due->reject == 1) {
            return redirect()->route("admin.$this->fileName.index")->with('dengues',__('Oops, You Cant Make Any Action'));
        }
        $due->update([
            "accept"    => 1,
            "reject"    => 0,
        ]);

        Notification::create([
            'user_id'           => $due->provider_id,
            'order_id'          => 0,
            "notification_type" => "admin",
            "message"           => [
                "ar"    => "Thanks For Dues",
                "en"    => __("Thanks For Dues"),
            ],
        ]);

        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }

    public function reject(DuesModel $due) {
        if($due->accept == 1 || $due->reject == 1) {
            return redirect()->route("admin.$this->fileName.index")->with('dengues',__('Oops, You Cant Make Any Action'));
        }
        $due->update([
            "accept"    => 0,
            "reject"    => 1,
        ]);

        Notification::create([
            'user_id'           => $due->provider_id,
            'order_id'          => 0,
            "notification_type" => "admin",
            "message"           => [
                "ar"    => "Oops, We Reject For This Dues",
                "en"    => __("Oops, We Reject For This Dues"),
            ],
        ]);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }
}
