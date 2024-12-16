<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        \Auth::viaRequest('token', function ($request) {
            $token =  request()->header("authorization");
            $token = str_replace("Bearer ","",$token);
            return User::where('api_token', $token)->whereNotNull('api_token')->first();
        });

        
        $this->registerPolicies();

        //
    }
}
