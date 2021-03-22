<?php
use Illuminate\Support\Facades\Route;

// 管理画面へ
Route::get('/', 'DashboardController')->name('dashboard');

// 投稿の一覧を閲覧、編集画面遷移、更新、削除(show以外の処理)
Route::resource('posts', 'PostController')->except('show');