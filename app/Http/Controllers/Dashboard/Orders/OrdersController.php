<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
// Models
use App\Models\Order;
use App\Models\Order\Answer;

class ordersController extends Controller
{
    protected $fileName = "orders";
    protected $controllerName = "Orders";
    protected $routeName = "orders";

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
        $lists = Order::latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function answers(Request $request,Order $order) {
        $breadcrumb = [
            'title' =>  __("Answers List"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("$this->controllerName Answers"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $lists      = $order->answers()->latest()->paginate();
        return view("admin.pages.$this->fileName.answers",get_defined_vars());
    }

    public function show(Request $request,Order $order) {
        $breadcrumb = [
            'title' =>  __("Show $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("$this->controllerName List"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("Show $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.show",get_defined_vars());
    }

    public function destroy(Request $request,Order $order) {
        $order->images()->delete();
        $order->answers()->delete();
        $order->items()->delete();
        $order->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('This row has been deleted'));
    }

}
