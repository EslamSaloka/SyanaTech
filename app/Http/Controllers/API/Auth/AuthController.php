<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\OTPRequest;
use App\Http\Requests\API\Auth\CheckPhoneRequest;
use App\Http\Requests\API\Auth\ForgetPasswordRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
// Models
use App\Models\User;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Customer\CustomerResource;
use App\Http\Resources\API\Provider\ProviderResource;

class AuthController extends Controller
{

    public function login(LoginRequest $request) {
        $authOnce = \Auth::once([
            'phone'    => $request->phone,
            'password' => $request->password,
        ]);
        $user = false;
        if ($authOnce) {
            $user = User::find(\Auth::getUser()->id);
        }
        if (!$user) {
            return (new API)->isError(__("Phone Or Password Is Failed"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        $user->update([
            'api_token'        => generate_api_token(),
            'dev_token'        => $request->devices_token,
        ]);

        if(is_null($user->phone_verified_at)) {
            return (new API)->isError(__('Please verified Phone'))->addAttribute('action','phone_verified')->addAttribute('api_token',$user->api_token)->build();
        }
        if($user->user_type == User::TYPE_CUSTOMER) {
            return (new API)->setStatusOk()
                ->setMessage(__("Customer information"))
                ->setData(new CustomerResource($user))
                ->addAttribute('api_token',$user->api_token)
                ->build();
        }
        return (new API)->setStatusOk()
                ->setMessage(__("Provider information"))
                ->setData(new ProviderResource($user))
                ->addAttribute('api_token',$user->api_token)
                ->build();
    }

    public function checkCodeOTP(OTPRequest $request) {
        $user = User::where(['phone'=>$request->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__('This Phone Not Found'))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        if($user->otp != $request->otp) {
            return (new API)->isError(__("Oops, OTP is Failed"))->build(); 
        }
        $user->update([
            'phone_verified_at' => \Carbon\Carbon::now(),
            'api_token'         => generate_api_token(),
            'otp'               => rand(1000,9999),
        ]);
        if($user->user_type == User::TYPE_CUSTOMER) {
            return (new API)->setStatusOk()
                ->setMessage(__("User information"))
                ->setData(new CustomerResource($user))
                ->addAttribute('api_token',$user->api_token)
                ->build();
        }
        return (new API)->setStatusOk()
                ->setMessage(__("User information"))
                ->setData(new ProviderResource($user))
                ->addAttribute('api_token',$user->api_token)
                ->build();
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        $user = User::where(['phone'=>$request->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__("This Phone Not Found"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        $otp = rand(1000,9999);
        $user->update([
            "otp"   => $otp
        ]);
        // Send SMS
        if(env("SEND_SMS")) {
            (new \App\Support\SMS)->setPhone($user->phone)->setMessage($otp)->build();
        }
        return (new API)->isOk(__("Thanks"))->addAttribute("otp",$otp)->build();
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $user = User::where(['phone'=>$request->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__("This Phone Not Found"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        if($user->otp != $request->otp) {
            return (new API)->isError(__("Oops, OTP is Failed"))->build();
        }
        $user->update([
            'password'  => \Hash::make($request->password),
            'api_token' => generate_api_token(),
            'otp'       => rand(1000,9999),
        ]);
        return (new API)->isOk(__("Thanks For Change Your Password"))->build();
    }

    public function reSendOTP(CheckPhoneRequest $request)
    {
        $user = User::where(['phone'=>$request->phone])->first();
        if (is_null($user)) {
            return (new API)->isError(__("This Phone Not Found"))->build();
        }
        if($user->user_type == User::TYPE_ADMIN) {
            return (new API)->isError(__("Oops, This Account Can't be access to this area"))->build();
        }
        $otp = rand(1000,9999);
        $user->update([
            "otp"   => $otp
        ]);
        // Send SMS
        if(env("SEND_SMS")) {
            (new \App\Support\SMS)->setPhone($user->phone)->setMessage($otp)->build();
        }
        return (new API)->isOk(__("Thanks"))->addAttribute("otp",$otp)->build();
    }

    public function logout()
    {
        \Auth::user()->update([
            'api_token'         => generate_api_token(),
            "devices_token"     => ""
        ]);
        return (new API)->isOk(__("LogOut"))->build();
    }
}
