<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests
use App\Http\Requests\API\Provider\ChangeCategoriesRequest;
use App\Http\Requests\API\Provider\ChangeCarCountryFactoriesRequest;
// Model
use App\Models\User;
// Helpers
use App\Helpers\API\API;

class ProviderSyncController extends Controller
{

    public function categories(ChangeCategoriesRequest $request) {
        \Auth::user()->categories()->sync($request->ids ?? []);
        return (new API)->setStatusOk()->setMessage(__("Sync Categories successfully"))->build();
    }

    public function carCountryFactories(ChangeCarCountryFactoriesRequest $request) {
        \Auth::user()->carCountryFactories()->sync($request->ids ?? []);
        return (new API)->setStatusOk()->setMessage(__("Sync Car Country Factories successfully"))->build();
    }
}
