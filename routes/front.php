<?php
use Illuminate\Support\Facades\Route;
 
// Route::get('/', function () {
//     echo 'front';
// });

// ホーム画面表示処理
Route::get('/', 'PostController@index')->name('home');

// 投稿一覧・詳細表示処理
Route::resource('/posts', 'PostController')->only(['index','show']);
