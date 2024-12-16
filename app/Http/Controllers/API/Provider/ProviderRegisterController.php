<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Auth\ProviderRegisterRequest;
// Models
use App\Models\User;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Provider\ProviderResource;

class ProviderRegisterController extends Controller
{

    public function index(ProviderRegisterRequest $request) {
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
            // 'first_name'                        => $request->first_name,
            'provider_name'                     => $request->provider_name,
            'phone'                             => $request->phone,
            'email'                             => $request->email,
            'password'                          => \Hash::make($request->password),
            'devices_token'                     => $request->devices_token,
            'user_type'                         => User::TYPE_PROVIDER,
            'api_token'                         => generate_api_token(),
            'how_to_know_us'                    => $request->how_to_know_us,
            'commercial_registration_number'    => $request->commercial_registration_number,
            'tax_number'                        => $request->tax_number,
            'region'                            => $request->region,
            'city'                              => $request->city,
            'lat'                               => $request->lat,
            'lng'                               => $request->lng,
            'otp'                               => $otp,
        ]);
        $user->categories()->sync($request->categories ?? []);
        $user->carCountryFactories()->sync($request->carCountryFactories ?? []);
        // \DB::table("user_register")->where(["phone"=>$request->phone])->delete();
        if(env("SEND_SMS")){
            (new \App\Support\SMS)->setPhone($request->phone)->setMessage($otp)->build();
        }
        return (new API)->setStatusOk()
            ->setMessage(__("Provider information"))
            ->setData(new ProviderResource($user))
            ->addAttribute('api_token',$user->api_token)
            ->addAttribute('otp',$otp)
            ->build();
    }
}
