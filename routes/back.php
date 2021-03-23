<?php
use Illuminate\Support\Facades\Route;

// 管理画面へ
Route::get('/', 'DashboardController')->name('dashboard');

// 投稿の一覧を閲覧、編集画面遷移、更新、削除(show以外の処理)
Route::resource('posts', 'PostController')->except('show');

// ユーザーの管理は管理権限(role=1)しか出来ない様にルーティング処理
Route::group(['middleware' => 'can:admin'], function () {
    Route::resource('users', 'UserController')->except('show');
});