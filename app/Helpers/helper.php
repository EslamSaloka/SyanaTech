<?php

use Illuminate\Support\Facades\Cache;

if(!function_exists('action_table_delete')) {
    function action_table_delete($route,$index = 0) {
        return '<form action="' . $route . '" method="post" id="form_'.$index.'">
        <input name="_method" type="hidden" value="delete">
        <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        <a class="btn btn-outline-danger btn-sm row_deleted" data-bs-toggle="modal" data-id="'.$index.'" data-bs-target="#staticBackdrop">
            <i class="bx bx-trash"></i>
        </a>
        </form>';
    }
}


if(!function_exists('getVinInformation')) {
    function getVinInformation($vin = "") {
        return [
            "make"  => request("make",""),
            "model" => request("models",""),
            "year"  => request("year",""),
        ];
    }
}


if (!function_exists('displayDuesForProvider')) {
    function displayDuesForProvider($provider) {
        $getDues = \App\Models\Dues\Item::whereHas("dues",function($q)use($provider){
            return $q->where("dues.provider_id",$provider->id)->where("dues.accept",1)->where("dues.reject",0);
        })->pluck("order_id")->toArray();

        $orders                 = $provider->providerOrders()->where('order_status',"done")->whereNotIn('id',$getDues)->orderBy('id','desc')->get(["id","created_at","sub_total"]);
        $commissionPrice        = $provider->commission_price ?? 0;
        $commissionPrice_P      = 0;
        foreach($orders as $order) {
            $commissionPrice_P  += ($commissionPrice == 0) ? 0 : ($order->sub_total * $commissionPrice) / 100;
        }
        return [
            "duesTotal" => $commissionPrice_P,
            "count"     => $orders->count(),
        ];
    }
}
if (!function_exists('silentFact')) {

    function silentFact($request,$values,$file,$merge = [])
    {
        $request = $request->all();
        foreach($values as $v) {
            if(isset($request[$v])) {
                $request[$v] = imageUpload($request[$v],$file);
            }
        }
        if(request()->has("password") && request("password") != '') {
            if(!is_null($request['password']) || $request['password'] != '') {
                $request['password'] = \Hash::make($request['password']);
            } else {
                unset($request['password']);
            }
        } else {
            if(array_key_exists("password",$request)) {
                unset($request['password']);
            }
        }
        if(!empty($merge)) {
            array_merge($request,$merge);
        }
        return $request;
    }
}

if (!function_exists('api_model_set_paginate')) {

    function api_model_set_paginate($model)
    {
        return [
            'total'         => $model->total(),
            'lastPage'      => $model->lastPage(),
            'perPage'       => $model->perPage(),
            'currentPage'   => $model->currentPage(),
        ];
    }
}

if (!function_exists('generate_api_token')) {
    function generate_api_token() {
        $random = \Illuminate\Support\Str::random(60);
        $check = \App\Models\User::where(['api_token' => $random])->first();
        if (!is_null($check)) {
            generate_api_token();
        }
        return $random;

    }
}

if (!function_exists('AppSettings')) {

    function AppSettings($var, $default = null)
    {
        $settings = \DB::table('settings')
                    ->join('setting_translations', 'setting_translations.setting_id', '=', 'settings.id')
                    ->select('settings.key','setting_translations.value')
                    ->get()->toArray();
        $data = array_column($settings, 'value', 'key');
        return isset($data[$var]) ? $data[$var] : $default;
    }
}

if (!function_exists('imageUpload')) {
    function imageUpload($image, $path = null, $wh = [], $watermark = false) {
        $destinationPath = (is_null($path))? public_path('uploads'):public_path('uploads/'.$path);
        $mm = (is_null($path))?'uploads' :'uploads/'.$path;
        if(!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $imageName = rand(1,5000).'_'.time().'.'.$image->extension();
        $image->move($destinationPath, $imageName);
        return $mm.'/'.$imageName;
    }
}


if (!function_exists('display_image_by_model')) {
    function display_image_by_model($model,$key,$name = "name") {
        if(is_null($model)) {
            return "https://www.gravatar.com/avatar/".md5('123456');
        }
        if(is_null($model->$key)) {
            $name = explode(" ",$model->{$name});
            if(count($name) > 1) {
                $getName = $name[0].' '.$name[1];
            } else {
                $getName = $model->{$name[0]};
            }
            if(is_null($getName)) {
                // $getName = "A";
                return "https://www.gravatar.com/avatar/".md5('123456');
            }
            return "https://eu.ui-avatars.com/api/?uppercase=true&name=".$getName."&background=random";
        }
        return url($model->$key);
    }
}

if (!function_exists('displayImage')) {

    function displayImage($image)
    {
        if(!is_null($image)) {
            if(is_file(public_path($image))) {
                return url($image);
            }
            return "https://www.gravatar.com/avatar/".md5('info@bugaia.net');
        }
        return "https://www.gravatar.com/avatar/".md5('info@bugaia.net');
    }
}


if (!function_exists('getSettings')) {
    function getSettings($var = null, $default = null,$trans = false)
    {
        $settings = \App\Models\Setting::get()->toArray();
        $data = array_column($settings, 'value', 'key');
        if(is_null($var)) {
            return $data;
        }
        return isset($data[$var]) ? $data[$var] : $default;
    }
}


if (!function_exists('curl_get_url_content')) {
    function curl_get_url_content($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}


if(!function_exists('PushFireBaseNotification')) {
    function PushFireBaseNotification($title,$message,$device_token,$message_to='all') {
        $registrationIds = (is_array($device_token)) ? $device_token : [$device_token];
        $msg = [
            'title'         => $title,
            'type'          => 1,
            'tickerText'    => '',
            'vibrate'       => 1,
            'sound'         => 1,
            'largeIcon'     => 'large_icon',
            'smallIcon'     => 'small_icon',
        ];
        $msg['body'] = $message;
        if($message_to == "all") {
            $fields = [
                'notification' => $msg,
                'to'    => '/topics/all'
            ];
        } else {
            $fields = [
                'registration_ids' => $registrationIds,
                'notification' => $msg
            ];
        }
        $headers = [
            'Authorization: key='.getSettings('fire_base_server_key','00'),
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}


if (!function_exists('driverNearLocation')) {

    function nearLocation($lat, $lng,$user_type = "provider")
    {

        $distance = 1000;

        $query = <<<EOF

        SELECT `id` FROM (

          SELECT *,

              (

                  (

                      (

                          acos(

                              sin(( $lat * pi() / 180))

                              *

                              sin(( `lat` * pi() / 180)) + cos(( $lat * pi() /180 ))

                              *

                              cos(( `lat` * pi() / 180)) * cos((( $lng - `lng`) * pi()/180)))

                      ) * 180/pi()

                  ) * 60 * 1.1515 * 1.609344

              )

          as distance FROM `users`

      ) users

      WHERE distance <= $distance AND user_type = "$user_type"

      LIMIT 1000

EOF;
        $users = \DB::select($query);
        $array = [];
        foreach($users as $user) {
            $array[] = $user->id;
        }
        return $array;
    }
}

// if (!function_exists('customRequestCaptcha')) {
//     function customRequestCaptcha() {
//         return new \ReCaptcha\RequestMethod\Post();
//     }
// }
