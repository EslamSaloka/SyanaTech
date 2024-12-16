<?php

use App\Models\Notification;

if (!function_exists('setNotification')) {

    function setNotification($user,$type = "new",$order = null)
    {
        $by = '';
        if($type == "close") {
            if($order->close_by == "provider") {
                $by = $order->provider->first_name;
            } else {
                $by = $order->customer_name;
            }
        }
        $title = env('APP_NAME');

        $texts = [
            "new"            => "You Have A New Order Form :USER Order Number #:ORDER",
            "process"        => "Your Order Number #:ORDER In Process",
            "wait_for_pay"   => "Your Order Number #:ORDER Wait Confirm Pay",
            "done"           => "Your Order Number #:ORDER End Successfully",
            "cancel"         => "Your Order Number #:ORDER End Canceled By :NAME",
        ];


        $data  = [
            "new"            => __($texts[$type],["USER"=>$order->customer_name,"ORDER"=>$order->id]),
            "process"        => __($texts[$type],["ORDER"=>$order->id]),
            "wait_for_pay"   => __($texts[$type],["ORDER"=>$order->id]),
            "done"           => __($texts[$type],["ORDER"=>$order->id]),
            "cancel"         => __($texts[$type],["ORDER"=>$order->id,"NAME"=>$by]),
        ];

        // Device Token
        $device_token = '';
        if($type == "new") {
            $device_token = $order->provider->device_token;
        } elseif($type == "process") {
            $device_token = $order->customer->device_token;
        } elseif($type == "wait_for_pay") {
            $device_token = $order->customer->device_token;
        } elseif($type == "done") {
            $device_token = $order->customer->device_token;
        } elseif($type == "close") {
            if($order->close_by == "provider") {
                $device_token = $order->provider->device_token;
            } else {
                $device_token = $order->customer->device_token;
            }
        }

        PushFireBaseNotification($title,$data[$type],$device_token,$user->user_type);
    }
}
