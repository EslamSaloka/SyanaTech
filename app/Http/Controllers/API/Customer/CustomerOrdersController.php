<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Orders\OrderCancelRequest;
use App\Http\Requests\API\Orders\OrderStoreRequest;
use App\Http\Requests\API\Orders\OrderRateRequest;
// Model
use App\Models\Order;
use App\Models\Rate;
use App\Models\Order\Answer;
use App\Models\Order\Item;
use App\Models\Order\Image;
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
use App\Models\Car;
use App\Models\User;

class CustomerOrdersController extends Controller
{

    public function index() {
        $orders = \Auth::user()->customerOrders();
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

    public function show(Order $order) {
        // Check If This Order Is For Auth Customer
        if($order->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function answers(Order $order) {
        // Check If This Order Is For Auth Customer
        if($order->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        $answers = $order->answers()->orderBy('id','desc')->paginate();
        return (new API)->isOk(__("Answers lists"))
            ->setData(AnswerResource::collection($answers))
            ->addAttribute('paginate',api_model_set_paginate($answers))->build();
    }

    public function acceptAnswer(Order $order,Answer $answer) {
        // Check If This Order Is For Auth Customer
        if($order->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        // Check If This Order Have Provider Before
        if(!is_null($order->provider_id) || $order->provider_id != 0) {
            return (new API)->isError(__("Oops, This Order Have Provider"))->build();
        }
        // Check If This Order Have New
        if($order->order_status != "new") {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        // Check If This Order Have This Answer
        if($order->id != $answer->order_id) {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        $order->update([
            'order_status'  => "process",
            'provider_id'   => $answer->provider_id,
            'process_at'    => \Carbon\Carbon::now(),
        ]);
        $answer->update([
            'accept'    => 1
        ]);

        // PUsh Notification And Make Notification

        Notification::create([
            'user_id'           => $answer->provider_id,
            'order_id'          => $order->id,
            "notification_type" => "system",
            "message"           => [
                "ar"    => __("العميل :CUSTOMER تم الموافقه علي عرضك في طلب رقم :ORDER",["CUSTOMER"=>\Auth::user()->first_name,"ORDER"=>$order->id]),
                "en"    => "The Customer ".\Auth::user()->first_name." Has Accepted To Your Answer On Order Number ".$order->id,
            ],
        ]);

         // Push Notification To Provider
         $bodyProvider = [
            "ar"    => __("العميل :CUSTOMER تم الموافقه علي عرضك في طلب رقم :ORDER",["CUSTOMER"=>\Auth::user()->first_name,"ORDER"=>$order->id]),
            "en"    => "The Customer ".\Auth::user()->first_name." Has Accepted To Your Answer On Order Number ".$order->id,
        ];
        (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
            ->setBody($bodyProvider)
            ->setTargetId($order->id)
            ->setTargetScreen("Order")
            ->setToken($order->provider->devices_token ?? '')
            ->build();

        // setNotification($order->provider,"process",$order);
        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function close(OrderCancelRequest $request,Order $order) {
        // Check If This Order Is For Auth Customer
        if($order->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Any Permeation To Access This Order"))->build();
        }
        // Check If This Order Have New
        if(in_array($order->order_status,["process","wait_for_pay","done","cancel"])) {
            return (new API)->isError(__("Oops, Can't Make Any Action On THis Order"))->build();
        }
        $order->update([
            "order_status"      => "cancel",
            "close_by"          => "customer",
            "close_by_id"       => \Auth::user()->id,
            "close_message"     => $request->refusal_id,
            "cancel_at"         => \Carbon\Carbon::now(),
        ]);

        if(!is_null($order->provider)) {
            // PUsh Notification And Make Notification
            Notification::create([
                'user_id'           => $order->provider_id,
                'order_id'          => $order->id,
                "notification_type" => "system",
                "message"           => [
                    "ar"    => __("العميل :CUSTOMER تم إلغاء الطلب رقم :ORDER",["CUSTOMER"=>\Auth::user()->first_name,"ORDER"=>$order->id]),
                    "en"    => "The Customer ".\Auth::user()->first_name." Has Canceled Order Number ".$order->id,
                ],
            ]);

             // Push Notification To Provider
            $bodyProvider = [
                "ar"    => __("العميل :CUSTOMER تم إلغاء الطلب رقم :ORDER",["CUSTOMER"=>\Auth::user()->first_name,"ORDER"=>$order->id]),
                "en"    => "The Customer ".\Auth::user()->first_name." Has Canceled Order Number ".$order->id,
            ];
            (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
                ->setBody($bodyProvider)
                ->setTargetId($order->id)
                ->setTargetScreen("Order")
                ->setToken($order->provider->devices_token ?? '')
                ->build();
        }
        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

    public function storeRate(OrderRateRequest $request) {
        $order = Order::find($request->order_id);
        if(is_null($order)) {
            return (new API)->isError(__("Oops, This Order Not Found"))->build();
        }
        if($order->customer_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have This Order"))->build();
        }
        if($order->rate == 1) {
            return (new API)->isError(__("Oops, You Rate This Order Before"))->build();
        }
        $checkRate = Rate::where([
            'customer_id'   => \Auth::user()->id,
            'provider_id'   => $order->provider_id,
            'order_id'      => $request->order_id,
        ])->first();
        if(!is_null($checkRate)) {
            return (new API)->isError(__("Oops, You Rate Before"))->build();
        }
        Rate::create([
            'customer_id'   => \Auth::user()->id,
            'provider_id'   => $order->provider_id,
            'order_id'      => $request->order_id,
            "rate"          => $request->rate,
            "message"       => $request->message ?? ''
        ]);
        $p = Rate::where(['provider_id'=>$order->provider_id]);
        $order->provider()->update([
            'rates' => $p->sum('rate') / $p->count()
        ]);
        $order->update([
            'rate' => 1
        ]);
        return (new API)->isOk(__("Thanks"))->build();
    }

    public function showInvoice(Order $order) {
        if($order->customer_id != \Auth::user()->id) {
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

    public function store(OrderStoreRequest $request) {

        $checkRate = Order::where("customer_id","=",\Auth::user()->id)
                    ->where("rate","=",0)
                    ->whereIn("order_status",["done"])->first();
        if($checkRate) {
            return (new API)->isError(__("Oops, You Can't Make New Order Rate Old Order Before"))->setData(["order_id"=>$checkRate->id])->build();
        }


        $car = Car::where(["id"=>$request->car_id])->first();
        if(is_null($car)) {
            return (new API)->isError(__("This Car Not Found"))
            ->setErrors([
                'car_id'   => __('This Car Not Found')
            ])
            ->build();
        }


        $checkOrder = Order::where("customer_id","=",\Auth::user()->id)
                ->where("car_id","=",$request->car_id)
                ->where("category_id","=",$request->category_id)
                ->whereIn("order_status",["new","process","wait_for_pay"])->count();
        if($checkOrder > 0) {
            return (new API)->isError(__("Oops, You Make This Order Before"))->build();
        }
        // ================================================================================= //
        // =================== Check Provider If Request Has Provider Id =================== //
        // ================================================================================= //

        if(request()->has('provider_id')) {
            $provider = User::where(["user_type"=>User::TYPE_PROVIDER,"id"=>$request->provider_id])->first();

            // Check If This Provider On System
            if(is_null($provider)) {
                return (new API)->isError(__("This Provider Not Found"))
                ->setErrors([
                    'provider_id'   => __('This Provider Not Found')
                ])
                ->build();
            }

            // Check If This Provider Supporter This Car
            if(!in_array($car->car_country_factory_id,$provider->carCountryFactories()->pluck("car_id")->toArray())) {
                return (new API)->isError(__("This Provider Not Supporter This Car"))
                ->setErrors([
                    'car_id'   => __('This Provider Not Supporter This Car')
                ])
                ->build();
            }

            // Check If This Provider Supporter This Category
            if(!in_array($request->category_id,$provider->categories()->pluck("category_id")->toArray())) {
                return (new API)->isError(__("This Provider Not Supporter This Category"))
                ->setErrors([
                    'category_id'   => __('This Provider Not Supporter This Category')
                ])
                ->build();
            }

            // Check If This Provider Supporter This City
            if($request->city_id != $provider->city) {
                return (new API)->isError(__("This Provider Not Supporter This City"))
                ->setErrors([
                    'city_id'   => __('This Provider Not Supporter This City')
                ])
                ->build();
            }

            // Check If This Provider Supporter This Region
            if($request->region_id != $provider->region) {
                return (new API)->isError(__("This Provider Not Supporter This Region"))
                ->setErrors([
                    'region_id'   => __('This Provider Not Supporter This Region')
                ])
                ->build();
            }

        }


        // ================================================================================= //
        // ================================================================================= //
        // ================================================================================= //
        $order = Order::create([
            "customer_id"           => \Auth::user()->id,
            "car_id"                => $request->car_id,
            "category_id"           => $request->category_id,
            "region_id"             => $request->region_id,
            "city_id"               => $request->city_id,
            "provider_id"           => $request->provider_id,
            "customer_name"         => \Auth::user()->first_name." ".\Auth::user()->last_name,
            "address_name"          => $request->address_name,
            "location_name"         => $request->location_name,
            "lat"                   => $request->lat,
            "lng"                   => $request->lng,
            "order_place"           => $request->order_place,
            "description"           => $request->description,
        ]);
        $order->update([
            "car_country_factory_id"    => $order->car->car_country_factory_id,
            "car_information"           => new \App\Http\Resources\API\Cars\CarsResource($order->car)
        ]);
        if(request()->has('provider_id')) {
            $order->update([
                "order_status"    => "process",
            ]);
        }
        if(request()->has('images')) {
            foreach($request->images as $image) {
                Image::create([
                    "order_id"  => $order->id,
                    "image"     => imageUpload($image,"orders/".$order->id),
                ]);
            }
        }
        if(request()->has('provider_id')) {
            // Push Notification To Provider
            $bodyProvider = [
                "ar"    => __("تم إنشاء طلب جديد من قبل العميل طلب رقم :ORDER",["ORDER"=>$order->id]),
                "en"    => "A new order was created by the customer Dial No. ".$order->id,
            ];
            (new \App\Support\FireBase)->setTitle(env('APP_NAME'))
                ->setBody($bodyProvider)
                ->setTargetId($order->id)
                ->setTargetScreen("Order")
                ->setToken($order->provider->devices_token ?? '')
                ->build();
        }


        return (new API)->isOk(__("Order Information"))->setData(new OrdersResource($order))->build();
    }

}
