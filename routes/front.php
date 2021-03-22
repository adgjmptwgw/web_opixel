<?php
use Illuminate\Support\Facades\Route;
 
// Route::get('/', function () {
//     echo 'front';
// });

// ホーム画面表示
// Route::get('/', 'PostController@index')->name('home');
Route::get('/', [App\Http\Controllers\Front\PostController::class, 'index'])->name('home');

// Route::get('/posts', [App\Http\Controllers\Front\PostController::class, 'index']);
// Route::get('/posts', [App\Http\Controllers\Front\PostController::class, 'show']);

Route::resource('/posts', 'PostController')->only(['index','show']);
// Route::resource('/posts', App\Http\Controllers\Front\PostController::class)->only([
//   'index', 'show'
// ]);