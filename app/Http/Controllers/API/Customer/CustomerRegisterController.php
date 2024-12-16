<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Auth\CustomerRegisterRequest;
// Models
use App\Models\User;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Customer\CustomerResource;

class CustomerRegisterController extends Controller
{

    public function index(CustomerRegisterRequest $request) {
        $email = User::where('email',$request->email)->first();
        if (!is_null($email)) {
            return (new API)->isError(__("This Email Address Used Before"))->build();
        }
        $phone = User::where('phone',$request->phone)->first();
        if (!is_null($phone)) {
            return (new API)->isError(__("This Phone Number Used Before"))->build();
        }
        $otp = rand(1000,9999);
        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'password'          => \Hash::make($request->password),
            'devices_token'     => $request->devices_token,
            'user_type'         => User::TYPE_CUSTOMER,
            'api_token'         => generate_api_token(),
            'how_to_know_us'    => $request->how_to_know_us,
            'region'            => $request->region,
            'city'              => $request->city,
            'lat'               => $request->lat,
            'lng'               => $request->lng,
            'otp'               => $otp,
        ]);
        if(env("SEND_SMS")){
            (new \App\Support\SMS)->setPhone($request->phone)->setMessage($otp)->build();
        }
        return (new API)->setStatusOk()
            ->setMessage(__("Customer information"))
            ->setData(new CustomerResource($user))
            ->addAttribute('api_token',$user->api_token)
            ->addAttribute('otp',$otp)
            ->build();
    }
}
