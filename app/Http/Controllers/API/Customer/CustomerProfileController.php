<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Customer\ChangePasswordRequest;
use App\Http\Requests\API\Customer\ChangeEmailRequest;
use App\Http\Requests\API\Customer\ChangePhoneRequest;
// Model
use App\Models\User;
// Helpers
use App\Helpers\API\API;
use App\Http\Requests\API\Profile\UpdateProfileRequest;
// Resources
use App\Http\Resources\API\Customer\CustomerResource;

class CustomerProfileController extends Controller
{

    public function index() {
        return (new API)->setStatusOk()->setMessage(__("User information"))->setData(new CustomerResource(\Auth::user()))->build();
    }

    public function update() {
        $data = request()->only([
            "first_name",
            "last_name",
            "region",
            "city",
            "lat",
            "lng",
        ]);
        // Image || how to know us
        if(!empty($data)) {
            \Auth::user()->update($data);
        }
        if(request()->has("avatar")) {
            \Auth::user()->update([
                "avatar"    =>  imageUpload(request("avatar"),"customer")
                ]);
        }
        return (new API)->isOk(__("Your Profile Has Been Updated"))->setData(new CustomerResource(\Auth::user()))->build();
    }

    public function changePassword(ChangePasswordRequest $request) {
        if(!\Hash::check($request->old_password, \Auth::user()->password)) {
            return (new API)->isError(__("Oops, Your old password is failed"))->build();
        }
        \Auth::user()->update([
            'password'  => \Hash::make($request->password)
        ]);
        return (new API)->isOk(__("Your Password Has Been Changed"))->build();
    }

    public function changeEmail(ChangeEmailRequest $request) {
        if(!\Hash::check($request->password, \Auth::user()->password)) {
            return (new API)->isError(__("Oops, Your password is falid"))->build();
        }
        $check = User::where(['email'=> $request->email])->first();
        if(!is_null($check)) {
            if($check->id != \Auth::user()->id) {
                return (new API)->isOk(__("Oops, This Email Used On Anther Account"))->build();
            }
        }
        \Auth::user()->update(['email'  => $request->email]);
        return (new API)->isOk(__("Your Email Has Been Changed"))->build();
    }

    public function changePhone(ChangePhoneRequest $request) {
        if(!\Hash::check($request->password, \Auth::user()->password)) {
            return (new API)->isError(__("Oops, Your password is falid"))->build();
        }
        $check = User::where(['phone'=> $request->phone])->first();
        if(!is_null($check)) {
            if($check->id != \Auth::user()->id) {
                return (new API)->isOk(__("Oops, This Phone Used On Anther Account"))->build();
            }
        }
        \Auth::user()->update(['phone'=> $request->phone]);
        return (new API)->isOk(__("Your Phone Has Been Changes"))->build();
    }

    public function destroy() {
        $cars = Car::where("customer_id",\Auth::user()->id)->get();
        foreach ($cars as $car){
            $car->delete();
        }

        \Auth::user()->delete();
        return (new API)->isOk(__("Your Account Has Deleted"))->build();
    }
}
