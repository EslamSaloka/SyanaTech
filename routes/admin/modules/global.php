<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;

// =================================== //
// =================================== //
// =================================== //
use App\Http\Controllers\Dashboard\KnowUs\KnowUsController;
use App\Http\Controllers\Dashboard\Areas\AreasController;
use App\Http\Controllers\Dashboard\Categories\CategoriesController;
use App\Http\Controllers\Dashboard\Intros\IntrosController;
use App\Http\Controllers\Dashboard\Sliders\SlidersController;
use App\Http\Controllers\Dashboard\Colors\ColorsController;
use App\Http\Controllers\Dashboard\Refusals\RefusalsController;
use App\Http\Controllers\Dashboard\CarFactories\CarFactoriesController;
use App\Http\Controllers\Dashboard\Cars\CarsController;
use App\Http\Controllers\Dashboard\Contents\ContentsController;
// =================================== //
use App\Http\Controllers\Dashboard\Dues\DuesController;
use App\Http\Controllers\Dashboard\Notifications\NotificationsController;
// =================================== //
use App\Http\Controllers\Dashboard\Banks\BanksController;
// =================================== //
use App\Http\Controllers\Dashboard\Admins\AdminsController;
use App\Http\Controllers\Dashboard\CarModal\CarModalController;
use App\Http\Controllers\Dashboard\Customers\CustomersController;
use App\Http\Controllers\Dashboard\Providers\ProvidersController;
// =================================== //
use App\Http\Controllers\Dashboard\Orders\OrdersController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Profile
Route::get('/profile', [ProfileController::class,'index'])->name('profile.index');
Route::post('/profile', [ProfileController::class,'store'])->name('profile.store');
// Logout
Route::get('/logout', [HomeController::class,'logout'])->name('logout');

// =================================== //
// =================================== //
// =================================== //

Route::resource('/know_us', KnowUsController::class); // Done
Route::resource('/colors', ColorsController::class); // Done
Route::resource('/refusals', RefusalsController::class); // Done
Route::resource('/car_factories',CarFactoriesController::class); // Done
Route::resource('/car_modals',CarModalController::class); // Done


Route::resource('/sliders', SlidersController::class); // Done
Route::resource('/categories', CategoriesController::class); // Done
Route::resource('/intros', IntrosController::class); // Done
Route::resource('/contents', ContentsController::class); // Done

Route::resource('/cars', CarsController::class); // Done

Route::resource('/areas', AreasController::class); // Done

Route::resource('/admins', AdminsController::class); // Done
Route::resource('/customers', CustomersController::class); // Done
Route::get('/providers/{provider}/rates', [ProvidersController::class,"rates"])->name("providers.rates")->where('provider','[0-9]+'); // Done
Route::get('/providers/{provider}/approved', [ProvidersController::class,"approved"])->name("providers.approved")->where('provider','[0-9]+'); // Done
Route::post('/providers/change-vat', [ProvidersController::class,"changeVat"])->name("providers.change-vat"); // Done
Route::resource('/providers', ProvidersController::class); // Done

Route::resource('/banks', BanksController::class); // Done


Route::get('/orders/{order}/answers', [OrdersController::class,"answers"])->name('orders.answers')->where('answer','[0-9]+');
Route::resource('/orders', OrdersController::class)->only(["index","show","destroy"]);

Route::get('/dues', [DuesController::class,"index"])->name('dues.index'); // Done
Route::get('/dues/{due}', [DuesController::class,"show"])->name('dues.show')->where("due","[0-9]+"); // Done
Route::get('/dues/{due}/accept', [DuesController::class,"accept"])->name('dues.accept')->where("due","[0-9]+"); // Done
Route::get('/dues/{due}/reject', [DuesController::class,"reject"])->name('dues.reject')->where("due","[0-9]+"); // Done
Route::resource('/notifications', NotificationsController::class)->only("index","store"); // Done

Route::get('/get-cities/{region}', function($region){
    return view("admin.pages.areas.cities",[
        "cities"=>\App\Models\Area::where('parent',$region)->get()
    ])->render();
})->name("get-cities")->where("region","[0-9]+"); // Done
