<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Provider\ChangePasswordRequest;
use App\Http\Requests\API\Provider\ChangeEmailRequest;
use App\Http\Requests\API\Provider\ChangePhoneRequest;
use App\Http\Requests\API\Provider\AddUpdateTermsRequest;
// Model
use App\Models\User;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Provider\ProviderResource;

class ProviderProfileController extends Controller
{

    public function index() {
        return (new API)->setStatusOk()->setMessage(__("Provider information"))->setData(new ProviderResource(\Auth::user()))->build();
    }

    public function update() {
        $data = request()->only([
            'provider_name',
            // 'last_name',
            'commercial_registration_number',
            'tax_number',
            'region',
            'city',
            'lat',
            'lng',
            'how_to_know_us',
        ]);
        if(!empty($data)) {
            \Auth::user()->update($data);
        }
        if(request()->has("avatar")) {
            \Auth::user()->update([
                "avatar"    =>  imageUpload(request("avatar"),"customer")
                ]);
        }
        return (new API)->isOk(__("Your Profile Has Been Updated"))->setData(new ProviderResource(\Auth::user()))->build();
    }

    public function changePassword(ChangePasswordRequest $request) {
        if(!\Hash::check($request->old_password, \Auth::user()->password)) {
            return (new API)->isError(__("Oops, Your password is failed"))->build();
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

    public function AddUpdateTerms(AddUpdateTermsRequest $request) {
        \Auth::user()->update(request()->only(["terms"]));
        return (new API)->isOk(__("Your Terms Has Been Changes"))->build();
    }

    public function destroy() {
        \Auth::user()->delete();
        return (new API)->isOk(__("Your Account Has Deleted"))->build();
    }
}
