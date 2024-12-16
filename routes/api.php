<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Auth
use App\Http\Controllers\API\Auth\AuthController;
// Settings
use App\Http\Controllers\API\Settings\SettingsController;
// Categories
use App\Http\Controllers\API\Categories\CategoriesController;
// ContactUs
use App\Http\Controllers\API\ContactUs\ContactUsController;
// Sliders
use App\Http\Controllers\API\Sliders\SlidersController;
// Areas
use App\Http\Controllers\API\Areas\AreasController;
// CarCountryFactory
use App\Http\Controllers\API\CarCountryFactory\CarCountryFactoryController;
// Customer
use App\Http\Controllers\API\Customer\CustomerRegisterController;
use App\Http\Controllers\API\Customer\CustomerProfileController;
use App\Http\Controllers\API\Customer\CustomerCarsController;
use App\Http\Controllers\API\Customer\CustomerSearchController;
use App\Http\Controllers\API\Customer\CustomerOrdersController;
use App\Http\Controllers\API\Customer\CustomerNotificationController;
// Provider
use App\Http\Controllers\API\Provider\ProviderRegisterController;
use App\Http\Controllers\API\Provider\ProviderProfileController;
use App\Http\Controllers\API\Provider\ProviderSyncController;
use App\Http\Controllers\API\Provider\ProviderOrdersController;
use App\Http\Controllers\API\Provider\ProviderNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->middleware("auth:api");
// Re-Send
Route::post('/re-send',[AuthController::class, 'reSendOTP']);
// Check Code OTP
Route::post('/check-code-otp',[AuthController::class, 'checkCodeOTP']);
// Forget Password
Route::post('/forget-password',[AuthController::class, 'forgetPassword']);
// Reset Password
Route::post('/reset-password',[AuthController::class, 'resetPassword']);


// Settings
Route::get('/settings',[SettingsController::class, 'index']);
// Intro
Route::get('/intro-page',[SettingsController::class, 'introPage']);
// Refusals
Route::get('/refusals',[SettingsController::class, 'refusals']);
// knowUs
Route::get('/knowUs',[SettingsController::class, 'knowUs']);
// car-colors
Route::get('/car-colors',[SettingsController::class, 'carColors']);
// car make models
Route::get('/cars-get-make',[SettingsController::class, 'carGetMake']);
Route::get('/cars-get-models/{carModal}',[SettingsController::class, 'carGetModels'])->where("carModal","[0-9]+");
// banks
Route::get('/banks',[SettingsController::class, 'getBanks']);
// Contents
Route::get('/contents',[SettingsController::class, 'pagesLists']);
Route::get('/contents/{content}',[SettingsController::class, 'show'])->where('content','[0-9]+');
// Send Message
Route::post('/send-message',[ContactUsController::class, 'store'])->middleware("auth:api");
// Sliders
Route::get('/sliders',[SlidersController::class, 'index']);
// Categories
Route::get('/categories',[CategoriesController::class, 'index']);
// Car Country Factory
Route::get('/car-country-factories',[CarCountryFactoryController::class, 'index']);
// Areas
Route::get('/areas',[AreasController::class, 'index']);
Route::get('/areas/{area}',[AreasController::class, 'show'])->where('area','[0-9]+');


Route::prefix('/customer')->group(function(){
    // Register
    Route::post('/register',[CustomerRegisterController::class, 'index']);
    Route::middleware(["auth:api","auth.customer"])->group(function(){
        // My Profile
        Route::get('/my-profile',[CustomerProfileController::class, 'index']);
        Route::post('/my-profile',[CustomerProfileController::class, 'update']);
        Route::delete('/my-profile/delete-account',[CustomerProfileController::class, 'destroy']);

        Route::post('/my-profile/change-password',[CustomerProfileController::class, 'changePassword']);
        Route::post('/my-profile/change-phone',[CustomerProfileController::class, 'changePhone']);
        Route::post('/my-profile/change-email',[CustomerProfileController::class, 'changeEmail']);
        // // Notification
        Route::get('/notifications',[CustomerNotificationController::class, 'index']);
        Route::delete('/notifications/{notification}',[CustomerNotificationController::class, 'destroy'])->where('notification','[0-9]+');
        // Orders
        Route::get('/orders',[CustomerOrdersController::class, 'index']);
        Route::post('/orders',[CustomerOrdersController::class, 'store']);
        Route::get('/orders/{order}',[CustomerOrdersController::class, 'show'])->where('order','[0-9]+');
        Route::get('/orders/{order}/show-Invoice',[CustomerOrdersController::class, 'showInvoice'])->where('order','[0-9]+');
        Route::get('/orders/{order}/answers',[CustomerOrdersController::class, 'answers'])->where('order','[0-9]+');
        Route::get('/orders/{order}/answers/{answer}/accept',[CustomerOrdersController::class, 'acceptAnswer'])->where('order','[0-9]+')->where('answer','[0-9]+');
        Route::post('/orders/{order}/cancel',[CustomerOrdersController::class, 'close'])->where('order','[0-9]+');


        // Rate
        Route::post('/provider-rate',[CustomerOrdersController::class, 'storeRate']);
        // My Cars
        Route::get('/my-cars',[CustomerCarsController::class, 'index']);
        Route::post('/my-cars',[CustomerCarsController::class, 'store']);
        Route::put('/my-cars/{car}',[CustomerCarsController::class, 'update'])->where('car','[0-9]+');
        Route::get('/my-cars/{car}',[CustomerCarsController::class, 'show'])->where('car','[0-9]+');
        Route::delete('/my-cars/{car}',[CustomerCarsController::class, 'destroy'])->where('car','[0-9]+');
        // Get Providers
        Route::post('/get-providers',[CustomerSearchController::class, 'index']);
        // Get Categories By Provider
        Route::post('/get-categories-by-provider',[CustomerSearchController::class, 'getCategoriesByProvider']);
        // check-provider-supporter-car
        Route::post('/check-provider-supporter-car',[CustomerSearchController::class, 'checkProviderSupporterCar']);
    });
});

Route::prefix('/provider')->group(function(){
    // Register
    Route::post('/register',[ProviderRegisterController::class, 'index']);

    Route::middleware(["auth:api","auth.provider"])->group(function(){
        // My Profile
        Route::get('/my-profile',[ProviderProfileController::class, 'index']);
        Route::post('/my-profile',[ProviderProfileController::class, 'update']);
        Route::delete('/my-profile/delete-account',[ProviderProfileController::class, 'destroy']);

        Route::post('/my-profile/change-password',[ProviderProfileController::class, 'changePassword']);
        Route::post('/my-profile/change-phone',[ProviderProfileController::class, 'changePhone']);
        Route::post('/my-profile/change-email',[ProviderProfileController::class, 'changeEmail']);
        Route::post('/my-profile/add-update-terms',[ProviderProfileController::class, 'AddUpdateTerms']);
        Route::post('/my-profile/add-update-terms',[ProviderProfileController::class, 'AddUpdateTerms']);
        // My Profile
        Route::post('/my-profile/sync-categories',[ProviderSyncController::class, 'categories']);
        Route::post('/my-profile/sync-car-country-factories',[ProviderSyncController::class, 'carCountryFactories']);

        // Notification
        Route::get('/notifications',[ProviderNotificationController::class, 'index']);
        Route::delete('/notifications/{notification}',[ProviderNotificationController::class, 'destroy'])->where('notification','[0-9]+');
        // Orders
        Route::get('/orders',[ProviderOrdersController::class, 'index']);
        Route::get('/orders-need-answers',[ProviderOrdersController::class, 'needAnswers']);
        Route::get('/orders/{order}',[ProviderOrdersController::class, 'show'])->where('order','[0-9]+');
        Route::get('/orders/{order}/show-Invoice',[ProviderOrdersController::class, 'showInvoice'])->where('order','[0-9]+');

        Route::post('/orders/{order}/make-answer',[ProviderOrdersController::class, 'makeAnswer'])->where('order','[0-9]+');
        Route::post('/orders/{order}/cancel',[ProviderOrdersController::class, 'close'])->where('order','[0-9]+');
        Route::post('/orders/{order}/add-update-bill',[ProviderOrdersController::class, 'updateOrCreate'])->where('order','[0-9]+');
        Route::get('/orders/{order}/confirm-take-money',[ProviderOrdersController::class, 'takeMoney'])->where('order','[0-9]+');
        // Dues
        Route::get('/dues',[ProviderOrdersController::class, 'dues']);
        Route::post('/dues',[ProviderOrdersController::class, 'duesStore']);
    });
});

Route::get('/callback',[ProviderOrdersController::class, 'duesCallBack']);

Route::get('/db_install_car_modals',function() {
    if(\App\Models\CarModal::count() > 0) {
        return 'You Have Data';
    }
    $data = json_decode(file_get_contents(public_path("cars.json")),true);
    foreach($data as $k=>$v) {
        $d = [
            "ar"    => [
                "name"  => $k
            ],
            "en"    => [
                "name"  => $k
            ],
            "parent_id" => 0
        ];
        $new = \App\Models\CarModal::create($d);
        foreach($v as $i) {
            $dd = [
                "ar"    => [
                    "name"  => $i
                ],
                "en"    => [
                    "name"  => $i
                ],
                "parent_id" => $new->id
            ];
            \App\Models\CarModal::create($dd);
        }
    }
    return "Done";
});
