<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Helpers
use App\Helpers\API\API;
use App\Models\Content;
use App\Models\Intro;
use App\Models\Refusal;
use App\Models\KnowUs;
use App\Models\Color;
use App\Models\Bank;
// Resources
use App\Http\Resources\API\Intro\IntroResource;
use App\Http\Resources\API\Refusals\RefusalsResource;
use App\Http\Resources\API\Content\ContentsResource;
use App\Http\Resources\API\Content\ContentResource;
use App\Http\Resources\API\HowToKnowUs\HowToKnowUsResource;
use App\Http\Resources\API\CarColors\CarColorsResource;
use App\Http\Resources\API\Banks\BanksResource;
use App\Http\Resources\API\CarMake\CarMakeResource;
use App\Http\Resources\API\CarMake\CarMakeChildrenResource;
use App\Models\CarModal;

class SettingsController extends Controller
{
    public function index() {
        $data['social'] = [
            'facebook'    => AppSettings('facebook',"https://fb.com"),
            'twitter'     => AppSettings('twitter',"https://twitter.com"),
            'instagram'   => AppSettings('instagram',"https://instagram.com"),
        ];
        $data['info'] = [
            'app_name'          => AppSettings('app_name','example'),
            'phone'             => AppSettings('phone',"0501234567"),
            'whatsapp'          => AppSettings('whatsapp',"0501234567"),
            'email'             => AppSettings('email','info@example.com'),
            // 'vat'               => AppSettings('vat',0),
            // 'dues'              => AppSettings('dues',0),
        ];
        return (new API)->setStatusOk()
            ->setMessage(__("Settings Lists"))
            ->setData($data)
            ->build();
    }

    public function pagesLists() {
        return (new API)->setStatusOk()
            ->setMessage(__("Pages Lists"))
            ->setData(ContentsResource::collection(Content::all()))
            ->build();
    }

    public function show(Content $content) {
        return (new API)->setStatusOk()
            ->setMessage(__("Show Page Information"))
            ->setData(new ContentResource($content))
            ->build();
    }

    public function introPage() {
        return (new API)->setStatusOk()
            ->setMessage(__("Intro Page Lists"))
            ->setData(IntroResource::collection(Intro::all()))
            ->build();
    }

    public function refusals() {
        return (new API)->setStatusOk()
            ->setMessage(__("Refusals Lists"))
            ->setData(RefusalsResource::collection(Refusal::all()))
            ->build();
    }

    public function knowUs() {
        return (new API)->setStatusOk()
            ->setMessage(__("Know Us Lists"))
            ->setData(HowToKnowUsResource::collection(KnowUs::all()))
            ->build();
    }

    public function carColors() {
        return (new API)->setStatusOk()
            ->setMessage(__("Color Lists"))
            ->setData(CarColorsResource::collection(Color::all()))
            ->build();
    }

    public function getBanks() {
        return (new API)->setStatusOk()
            ->setMessage(__("Banks Lists"))
            ->setData(BanksResource::collection(Bank::all()))
            ->build();
    }

    public function carGetMake() {
        return (new API)->setStatusOk()
            ->setMessage(__("Cars Make Models Lists"))
            ->setData(CarMakeResource::collection(CarModal::where("parent_id",0)->get()))
            ->build();
    }

    public function carGetModels(CarModal $carModal) {
        if($carModal->parent_id != 0) {
            return (new API)->isError(__("This Make Parent"))->build();
        }
        return (new API)->setStatusOk()
            ->setMessage(__($carModal->name ." Children Lists"))
            ->setData(CarMakeChildrenResource::collection($carModal->children()->get()))
            ->build();
    }
}
