<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include_once(app_path('Helpers/helper.php'));
        include_once(app_path('Helpers/notification.php'));
        // 
        // dd(request()->header('Accept-Language'));
        if(!is_null(request()->header('Accept-Language'))) {
            if(in_array(request()->header('Accept-Language'),array_keys(config("laravellocalization.supportedLocales")))) {
                \App::setLocale(request()->header('Accept-Language'));
            }
        }
    }
}
