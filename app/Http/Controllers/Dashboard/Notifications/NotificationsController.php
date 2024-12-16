<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Notifications\NotificationsRequest;
// Models
use App\Models\Notification as NotificationsModels;
use App\Models\User;

class NotificationsController extends Controller
{
    protected $fileName = "notifications";
    protected $controllerName = "Notifications";
    protected $routeName = "notifications";


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
        $users = User::whereIn("user_type",[User::TYPE_CUSTOMER,User::TYPE_PROVIDER])->get();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }
    
    public function store(NotificationsRequest $request) {
        if($request->user_id == "all") {
            $users = User::whereIn("user_type",[User::TYPE_CUSTOMER,User::TYPE_PROVIDER])->get();
        } elseif ($request->user_id == "all_providers") {
            $users = User::whereIn("user_type",[User::TYPE_PROVIDER])->get();
        } elseif ($request->user_id == "all_customers") {
            $users = User::whereIn("user_type",[User::TYPE_CUSTOMER])->get();
        } else {
            $users = User::where("id",$request->user_id)->get();
        }
        foreach($users as $user) {
            NotificationsModels::create([
                'user_id'           => $user->id,
                'order_id'          => 0,
                "notification_type" => "admin",
                "message"           => [
                    "ar"    => $request->message,
                    "en"    => $request->message,
                ],
            ]);
        }
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been created'));
    }
}
