<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Customer\SearchRequest;
use App\Http\Requests\API\Customer\SearchByProviderRequest;
use App\Http\Requests\API\Customer\CheckProviderSupporterCarRequest;
// Model
use App\Models\User;
// Helpers
use App\Helpers\API\API;
use App\Http\Resources\API\Categories\CategoriesResource;
// Resources
use App\Http\Resources\API\Provider\ProviderResource;
use App\Models\Car;

class CustomerSearchController extends Controller
{

    public function index(SearchRequest $request) {
        $providers = User::where('user_type',User::TYPE_PROVIDER)->whereHas('categories',function($q)use($request){
            return $q->where("provider_categories_pivot.category_id",$request->category_id);
        });
        if($request->search_by == "top_rate") {
            $providers = $providers->orderBy('rates','desc');
        }
        if($request->search_by == "near") {
            $ids = nearLocation($request->lat,$request->lng);
            $providers = $providers->whereIn('id',$ids);
        }
        if(request()->has('provider_name') && request('provider_name') != '') {
            $providers = $providers->where('provider_name',"like","%".request('provider_name')."%");
        }
        // city
        if(request()->has('city') && request('city') != '') {
            $providers = $providers->where('city',request('city'));
        }
        // region
        if(request()->has('region') && request('region') != '') {
            $providers = $providers->where('region',request('region'));
        }
        $providers = $providers->paginate();
        return (new API)->isOk(__("Providers Lists"))
            ->setData(ProviderResource::collection($providers))
            ->addAttribute('paginate',api_model_set_paginate($providers))
            ->build();
    }

    public function getCategoriesByProvider(SearchByProviderRequest $request) {
        $provider = User::where(["user_type"=>User::TYPE_PROVIDER,"id"=>$request->provider_id])->first();
        if(is_null($provider)) {
            return (new API)->isError(__("This Provider Not Found"))
            ->setErrors([
                'provider_id'   => __('This Provider Not Found')
            ])
            ->build();
        }
        $categories = $provider->categories()->get();
        return (new API)->isOk(__("Categories Lists"))
            ->setData(CategoriesResource::collection($categories))
            ->build();
    }

    public function checkProviderSupporterCar(CheckProviderSupporterCarRequest $request) {
        $provider = User::where(["user_type"=>User::TYPE_PROVIDER,"id"=>$request->provider_id])->first();
        if(is_null($provider)) {
            return (new API)->isError(__("This Provider Not Found"))
            ->setErrors([
                'provider_id'   => __('This Provider Not Found')
            ])
            ->build();
        }
        $car = Car::where(["id"=>$request->car_id])->first();
        if(is_null($car)) {
            return (new API)->isError(__("This Car Not Found"))
            ->setErrors([
                'car_id'   => __('This Car Not Found')
            ])
            ->build();
        }
        if(!in_array($car->car_country_factory_id,$provider->carCountryFactories()->pluck("car_id")->toArray())) {
            return (new API)->isError(__("This Provider Not Supporter This Car"))
            ->setErrors([
                'car_id'   => __('This Provider Not Supporter This Car')
            ])
            ->build();
        }
        return (new API)->isOk(__("Supporter"))->build();
    }

}
