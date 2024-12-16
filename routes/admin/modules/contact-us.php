<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ContactUs\ContactUsController;

// Contact Us
Route::resource('/contact-us', ContactUsController::class)->only(['index','show','destroy','update']);