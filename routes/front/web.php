<?php

use Illuminate\Support\Facades\Route;


Route::get('terms-conditions', function(){
    return view('terms');
});

Route::get('privacy-policy', function(){
    return view('privacy');
});


Route::get('/', function(){
    return view('welcome');
});
