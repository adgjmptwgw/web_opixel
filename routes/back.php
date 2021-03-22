<?php
use Illuminate\Support\Facades\Route;
 
Route::get('/', function () {
    echo 'back';
});

// Route::get('/', [App\Http\Controllers\Back\DashboardController::class])->name('dashboard');

Route::get('/', 'DashboardController')->name('dashboard');