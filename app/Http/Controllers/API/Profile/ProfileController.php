<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Profile\UpdateProfileRequest;
use App\Http\Requests\API\Profile\ChangePasswordeRequest;
use App\Http\Requests\API\Profile\ChangePhoneRequest;
use App\Http\Requests\API\Profile\ChangeEmailRequest;
// Models
use App\Models\User;
use App\Models\User\UserSubscription;
use App\Models\Notification;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\User\UserResource;

class ProfileController extends Controller
{
    public function index() {
        return (new API)->setStatusOk()
            ->setMessage(__("My Profile information"))
            ->setData(new UserResource(\Auth::user()))
            ->build();
    }

    public function update(UpdateProfileRequest $request) {
        $user    = \Auth::user();
        $request = $request->all();
        // $pp      = null;
        if(request()->has('phone')) {
            unset($request['phone']);
        }
        if(request()->has('password')) {
            unset($request['password']);
        }
        if(request()->has('email')) {
            unset($request['email']);
        }
        if(request()->has('devices_token')) {
            $request['dev_token'] = $request['devices_token'];
        }
        if(request()->hasFile('avatar')) {
            $request['avatar'] = imageUpload($request['avatar'],'users');
        }
        $user->update($request);
        $user = User::find($user->id);
        /*if(!is_null($pp)) {
            return (new API)->isOk(__("Please Check Active Your Phone"))->addAttribute('api_token',$user->api_token)->addAttribute('activated_code',$pp)->setData(new UserResource($user))->build();
        }*/
        return (new API)->isOk(__("Update My Profile information"))
            ->setData(new UserResource($user))
            ->addAttribute('api_token',$user->api_token)
            ->build();
    }

    public function changePassword(ChangePasswordeRequest $request) {
        if(!\Hash::check($request->old_password, \Auth::user()->password)) {
            return (new API)->isError(__("كلمه المرور القديمه غير صحيحه"))->build();
        }
        \Auth::user()->update([
                'password'  => \Hash::make($request->password)
            ]);
        return (new API)->isOk(__("تم تغير كلمه المرور بنجاح"))->build();
    }

    public function changeEmail(ChangeEmailRequest $request) {
        if(!\Hash::check($request->password, \Auth::user()->password)) {
            return (new API)->isError(__("كلمه المرور القديمه غير صحيحه"))->build();
        }
        \Auth::user()->update(['email'  => $request->email]);
        return (new API)->isOk(__("تم تغير البريد الإلكتروني"))->build();
    }

    public function changePhone(ChangePhoneRequest $request) {
        if(!\Hash::check($request->password, \Auth::user()->password)) {
            return (new API)->isError(__("كلمه المرور القديمه غير صحيحه"))->build();
        }
        \Auth::user()->update(['phone'=> $request->phone]);
        return (new API)->isOk(__("تم تغير رقم الجوال بنجاح"))->build();
    }

    public function logout() {
        \Auth::user()->update([
            'api_token' => null,
            'dev_token' => null,
            ]);
        return (new API)->isOk(__("تم تسجيل الخروج بنجاح"))->build();
    }

    public function checkMySubscription() {
        $list = UserSubscription::where(['user_id'=>\Auth::user()->id,'active'=>1])->first();
        if(is_null($list)) {
            return (new API)->isError(__("لا يوجد اشتراك , برجاء الإشتراك في باقة"))->build();
        }
        if(\Carbon\Carbon::parse($list->end) < \Carbon\Carbon::now()) {
            $list->update([
                'active'=>0
            ]);
            $title      = "تم الإنتهاء من الإشتراك الخاصه بك";
            $message    = [
                "ar"    => "نعتذرا منك ولكن تم ايقاف الخدمه لإنتهاء الإشتراك",
                "en"    => "We apologize to you but the service was stopped until the subscription ended"
            ];
            Notification::create([
                'user_id'   => $list->user_id,
                'model_id'  => $list->subscription_id,
                'title'     => $title,
                'message'   => $message,
                'type'      => "subscription",
            ]);
            PushFireBaseNotification($title,$message,"system","customer",$list->user->dev_token ?? '');
            return (new API)->isError($title)->build();
        }
        return (new API)->isOk(__("الإشتراك الخاص بك قيد التنفيذ"))->build();
    }
}
