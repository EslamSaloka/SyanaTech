<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$Middlewares = [
    'web',
    'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
    'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
    'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
    'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
];
Route::middleware($Middlewares)->prefix(\LaravelLocalization::setLocale())->group(function () {

    Route::name('admin.')->prefix('dashboard')->group(function () {
        Auth::routes();
        Route::middleware(['auth.dashboard'])->group(function () {
            include __DIR__.'/modules/global.php';
            include __DIR__.'/modules/contact-us.php';
            include __DIR__.'/modules/settings.php';
        });
    });

});
