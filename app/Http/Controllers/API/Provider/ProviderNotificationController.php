<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Model
use App\Models\Notification;
// Helpers
use App\Helpers\API\API;
// Resources
use App\Http\Resources\API\Notifications\NotificationsResource;

class ProviderNotificationController extends Controller
{

    public function index() {
        $notifications = \Auth::user()->getNotifications()->orderBy('id','desc')->paginate();
        return (new API)->isOk(__("Notifications Lists"))
            ->setData(NotificationsResource::collection($notifications))
            ->addAttribute('paginate',api_model_set_paginate($notifications))
            ->build();
    }

    public function destroy(Notification $notification) {
        if($notification->user_id != \Auth::user()->id) {
            return (new API)->isError(__("Oops, You Don't Have Permeation To Access This Car"))->build();
        }
        $notification->delete();
        return (new API)->isOk(__("This Notification Has Been Deleted"))->build();
    }

}
