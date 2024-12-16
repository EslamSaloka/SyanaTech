<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Settings\SettingsController;

// Settings
Route::get('/settings', [SettingsController::class,'index'])->name('settings.index');
Route::get('/settings/{group_by}', [SettingsController::class,'edit'])->name('settings.edit');
Route::put('/settings/{group_by}', [SettingsController::class,'update'])->name('settings.update');
