<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Orders\OrderCancelRequest;
use App\Http\Requests\API\Orders\OrderMakeAnswerRequest;
use App\Http\Requests\API\Orders\OrderMakeOrUpdateBillRequest;
use App\Http\Requests\API\Orders\DuesRequest;
// Model
use App\Models\Order;
use App\Models\Order\Answer;
use App\Models\Order\Item;
use App\Models\Dues;
use App\Models\Dues\Item as DuesItems;
use App\Models\Notification;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Orders\OrdersResource;

use App\Http\Resources\API\Orders\Order\AnswerResource;
use App\Http\Resources\API\Orders\Order\ItemResource;
use App\Http\Resources\API\Areas\AreasResource;
use App\Http\Resources\API\Customer\CustomerResource;
use App\Http\Resources\API\Provider\ProviderResource;

use App\Models\User;

class ProviderOrdersController extends Controller
{

    public function showInvoice(Order $order) {
        if($order->provider_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have This Order"))->build();
        }
        if($order->items()->count() == 0) {
            return (new API)->isError(__("Oops, This Order Don't Have Invoice"))->build();
        }
        return (new API)->isOk(__("Thanks"))->setData([
            "id"              => $order->id,
            "created_at"      => $order->created_at,
            "location"        => [
                "address_name"    => $order->address_name,
                "location_name"   => $order->location_name,
                "lat"             => $order->lat,
                "lng"             => $order->lng,
                "region"          => (is_null($order->region)) ? [] : new AreasResource($order->region),
                "city"            => (is_null($order->city)) ? [] : new AreasResource($order->city),
            ],
            "prices"          => [
                "sub_total"       => $order->sub_total ?? 0,
                "vat"             => $order->vat ?? 0,
                "total"           => $order->total ?? 0,
            ],
            "invoice_items"  => ItemResource::collection($order->items),
            "customer"       => new CustomerResource($order->customer),
            "provider"       => new ProviderResource($order->provider),
        ])->build();
    }

    public function index() {
        $orders = \Auth::user()->providerOrders();
        if(request()->has("order_status") && request("order_status") != "") {
            $status = [
                "new",
                "process",
                "wait_for_pay",
                "done",
                "cancel"
            ];
            if(in_array(request("order_status"),$status)) {
                $orders = $orders->where("order_status",request("order_status"));
            }
        }
        $orders = $orders->orderBy('id','desc')->paginate();
        return (new API)->isOk(__("Orders Lists"))
            ->setData(OrdersResource::collection($orders))
            ->addAttribute('paginate',api_model_set_paginate($orders))
            ->build();
    }

    public function needAnswers() {

        if(\Auth::user()->terms == "" || is_null(\Auth::user()->terms)) {
            return (new API)->isError(__("Oops, Please Completed Your Informations First"))->build();
        }
        // categories
        $categories = \Auth::user()->categories()->pluck('provider_categories_pivot.category_id')->toArray();
        // carCountryFactories
        $carCountryFactories = \Auth::user()->carCountryFactories()->pluck('provider_car_factories_pivot.car_id')->toArray();
        // =============== //
        $orders = Order::whereNull('provider_id')->whereIn('category_id',$categories)->whereIn("car_country_factory_id",$carCountryFactories)->where('city_id',\Auth::user()->city)->where('region_id',\Auth::user()->region)->orderBy('id','desc')->paginate();
        return (new API)->isOk(__("Orders Need Answers Lists"))
            ->setData(OrdersResource::collection($orders))
            ->addAttribute('paginate',api_model_set_paginate($orders))
            ->build();
    }

    public function show(Order $order) {
        if($order->provider_id != 0 || !is_null($order->provider_id)) {
            // Check If This Order Is For Auth Provider
            if($order->provider_id != \Auth::user()->id) {
                return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
            }
        }
        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function makeAnswer(OrderMakeAnswerRequest $request,Order $order) {
        if($order->provider_id != 0 || !is_null($order->provider_id)) {
            return (new API)->isError(__("Oops, This Order Have Provider"))->build();
        }
        // Check If This Order Have New
        if($order->order_status != "new") {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }

        // Check If I make Provider Answer
        $check = Answer::where([
            "order_id"      => $order->id,
            "provider_id"   => \Auth::user()->id,
        ])->first();
        if(!is_null($check)) {
            return (new API)->isError(__("Oops, You Make Answer Before"))->build();
        }
        Answer::create([
            "order_id"      => $order->id,
            "provider_id"   => \Auth::user()->id,
            "answer"        => $request->answer,
        ]);

        // PUsh Notification And Make Notification

        Notification::create([
            'user_id'           => $order->customer_id,
            'order_id'          => $order->id,
            "notification_type" => "system",
            "message"           => [
                "ar"    => __("مقدم الخدمة :PROVIDER فام بعرض سعر لطلبك برقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
                "en"    => "The Provider ".\Auth::user()->provider_name." Has Make Offer On Your Order Number ".$order->id,
            ],
        ]);

        // Push Notification FireBase
        $title = [
            "ar"    => __("مقدم الخدمة :PROVIDER فام بعرض سعر لطلبك برقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
            "en"    => "The Provider ".\Auth::user()->provider_name." Has Make Offer On Your Order Number ".$order->id,
        ];
        (new \App\Support\FireBase)->setTitle($title)
            ->setBody($title)
            ->setTargetId($order->id)
            ->setTargetScreen("Order")
            ->setToken($order->user->devices_token ?? '')
            ->build();

        return (new API)->isOk(__("Thanks For Answer"))->build();
    }

    public function close(OrderCancelRequest $request, Order $order) {
        // Check If This Order Is For Auth Provider
        if($order->provider_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        // Check If This Order Have New
        if(in_array($order->order_status,["wait_for_pay","done","cancel"])) {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        $order->update([
            "order_status"      => "cancel",
            "close_by"          => "provider",
            "close_by_id"       => \Auth::user()->id,
            "close_message"     => $request->message,
            "cancel_at"         => \Carbon\Carbon::now(),
        ]);

        // PUsh Notification And Make Notification
        Notification::create([
            'user_id'           => $order->customer_id,
            'order_id'          => $order->id,
            "notification_type" => "system",
            "message"           => [
                "ar"    => __("مقدم الخدمه :PROVIDER فام بإلغاء طلبك رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
                "en"    => "The Provider ".\Auth::user()->provider_name." Has Canceled Your Order Number ".$order->id,
            ],
        ]);

        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function takeMoney(Order $order) {
        // Check If This Order Is For Auth Provider
        if($order->provider_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        // Check If This Order Have New
        if($order->order_status != "wait_for_pay") {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        $order->update([
            "order_status"      => "done",
            "completed_at"      => \Carbon\Carbon::now(),
        ]);

        // PUsh Notification And Make Notification
        Notification::create([
            'user_id'           => $order->customer_id,
            'order_id'          => $order->id,
            "notification_type" => "system",
            "message"           => [
                "ar"    => __("مقدم الخدمة :PROVIDER قام بإكمال طلبك رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
                "en"    => "The Provider ".\Auth::user()->provider_name." Has Completed Your Order Number ".$order->id,
            ],
        ]);

        $body = [
            "ar"    => __("مقدم الخدمة :PROVIDER قام بإكمال طلبك رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
            "en"    => "The Provider ".\Auth::user()->provider_name." Has Completed Your Order Number ".$order->id,
        ];
        (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
            ->setBody($body)
            ->setTargetId($order->id)
            ->setTargetScreen("Order")
            ->setToken($order->user->devices_token ?? '')
            ->build();

        // Push Notification To Provider

        Notification::create([
            'user_id'           => $order->provider_id,
            'order_id'          => $order->id,
            "notification_type" => "system",
            "message"           => [
                "ar"    => __("برجاء سداد المستحقات لطلب رقم :ORDER",["ORDER"=>$order->id]),
                "en"    => "Please pay the dues to dial a number ".$order->id,
            ],
        ]);

        $bodyProvider = [
            "ar"    => __("برجاء سداد المستحقات لطلب رقم :ORDER",["ORDER"=>$order->id]),
            "en"    => "Please pay the dues to dial a number ".$order->id,
        ];

        (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
            ->setBody($bodyProvider)
            ->setTargetId($order->id)
            ->setTargetScreen("Order")
            ->setToken($order->provider->devices_token ?? '')
            ->build();

        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function updateOrCreate(OrderMakeOrUpdateBillRequest $request, Order $order) {
        // Check If This Order Is For Auth Customer
        if($order->provider_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        // Check If This Order Have New
        if($order->order_status != "process" && $order->order_status != "wait_for_pay") {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        $order->update([
            "sub_total"         => $request->sub_total,
            "vat"               => $request->vat,
            "commission_price"  => $request->commission_price ?? 0,
            "total"             => $request->total,
            "order_status"      => "wait_for_pay",
        ]);
        $checkItemOfInvoice = Item::where(["order_id"  => $order->id])->count();
        Item::where(["order_id"  => $order->id])->delete();
        if(request()->has('items')) {
            foreach($request->items as $item) {
                Item::create([
                    "order_id"  => $order->id,
                    "name"      => $item['name'],
                    "price"     => $item['price'],
                ]);
            }
        }

        // PUsh Notification And Make Notification
        if($checkItemOfInvoice == 0) {
            Notification::create([
                'user_id'           => $order->customer_id,
                'order_id'          => $order->id,
                "notification_type" => "system",
                "message"           => [
                    "ar"    => __("مقدم الخدمة :PROVIDER قام بإنشاء فاتوره لطلب رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
                    "en"    => "The Provider ".\Auth::user()->provider_name." Created A Invoice Of Order Number ".$order->id,
                ],
            ]);
        } else {
            Notification::create([
                'user_id'           => $order->customer_id,
                'order_id'          => $order->id,
                "notification_type" => "system",
                "message"           => [
                    "ar"    => __("مقدم الخدمة :PROVIDER قام بإنشاء فاتوره لطلب رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
                    "en"    => "The Provider ".\Auth::user()->provider_name." Created A Invoice Of Order Number ".$order->id,
                ],
            ]);
        }

        $body = [
            "ar"    => __("مقدم الخدمة :PROVIDER قام بإنشاء فاتوره لطلب رقم :ORDER",["PROVIDER"=>\Auth::user()->provider_name,"ORDER"=>$order->id]),
            "en"    => "The Provider ".\Auth::user()->provider_name." Created A Invoice Of Order Number ".$order->id,
        ];
        (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
            ->setBody($body)
            ->setTargetId($order->id)
            ->setTargetScreen("Order")
            ->setToken($order->user->devices_token ?? '')
            ->build();
        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function dues() {
        $provider = \Auth::user();
        Dues::where(["provider_id"=>$provider->id,"dues.accept"=>0])->delete();
        $getDues = DuesItems::whereHas("dues",function($q)use($provider){
            return $q->where("dues.provider_id",$provider->id)->where("dues.accept",1)->where("dues.reject",0);
        })->pluck("order_id")->toArray();
        $orders = $provider->providerOrders()->where('order_status',"done")->whereNotIn('id',$getDues)->orderBy('id','desc')->get(["id","created_at","sub_total"]);
        $p      = 0;
        $array  = [];
        $commissionPrice    = $provider->commission_price ?? 0;
        foreach($orders as $order) {
            $dues  = ($commissionPrice == 0) ? 0 : ($order->sub_total * $commissionPrice) / 100;
            $array[] = [
                "id"                        => $order->id,
                "created_at"                => \Carbon\Carbon::parse($order->created_at)->diffForHumans(),
                "order_cost"                => (float)$order->sub_total,
                "dues"                      => $dues,
            ];
            $p      = $p + $dues;
        }
        return (new API)->isOk(__("Dues lists"))->setData([
            'dues'              => $p,
            'orders'            => $array,
        ])->build();
    }

    public function duesStore() {

        $provider = \Auth::user();
        $getDues = DuesItems::whereHas("dues",function($q)use($provider){
            return $q->where("dues.provider_id",$provider->id)->where("dues.accept",1)->where("dues.reject",0);
        })->pluck("order_id")->toArray();
        $orders = $provider->providerOrders()->where('order_status',"done")->whereNotIn('id',$getDues)->orderBy('id','desc')->get(["id","created_at","sub_total"]);
        // $orders = Order::where('provider_id',\Auth::user()->id)->where('dues',1)->where('order_status',"done")->get(["total","id"]);
        if($orders->count() == 0) {
            return (new API)->isError(__("Oops, You Don't Have Dues"))->build();
        }
        $m = Dues::create([
            'provider_id'   => \Auth::user()->id
        ]);
        $dues  = 0;
        // $systemDues = AppSettings('dues',0);
        $commissionPrice    = $provider->commission_price ?? 0;
        foreach($orders as $order) {
            $b1 = ($commissionPrice == 0) ? 0 : ($order->sub_total * $commissionPrice) / 100;
            $dues  = $dues + $b1;
            DuesItems::create([
                "dues_id"       => $m->id,
                "order_id"      => $order->id,
                "order_total"   => $order->sub_total,
                "order_dues"    => $b1,
            ]);
        }
        $m->update(["total"=>$dues]);
        $payment = (new \App\Support\MyFatoorah)->getFields($m)->sendPayment();
        if($payment["status"] == false) {
            $m->delete();
            DuesItems::where(["order_id" => $order->id])->delete();
            return (new API)->isError(__($payment["message"]))->build();
        }
        $m->update(["invoiceId"=>$payment["invoiceId"]]);
        return (new API)->isOk(__("Thanks"))->setData($payment)->build();
    }

    public function duesCallBack(Request $request) {
        $pay = (new \App\Support\MyFatoorah)->callBack($request->paymentId);
        //$pay = $pay["Data"]["InvoiceTransactions"][0]["TransactionStatus"];
        //dd($pay);
        //if($pay["IsSuccess"]) {
        if($pay["Data"]["InvoiceTransactions"][0]["TransactionStatus"] == "Succss") {
            $due = \App\Models\Dues::where(["invoiceId"=>$pay["Data"]["InvoiceId"]]);
            if(is_null($due)) {
                return (new API)->isError(__("This invoice Not Found"))->build();
            }
            $due->update([
                "accept"=>1
            ]);
            return (new API)->isOk(__("تم السداد بنجاح ، شكرا لك"))->build();
        }
        return (new API)->isError(__("فشلت عملية السداد ، حاول مرة اخرى"))->build();
    }


}
