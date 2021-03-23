<?php
use Illuminate\Support\Facades\Route;
 
// Route::get('/', function () {
//     echo 'front';
// });

// ホーム画面表示処理
Route::get('/', 'PostController@index')->name('home');

// 投稿一覧・詳細表示処理
Route::resource('/posts', 'PostController')->only(['index','show']);

// 詳細ページへ遷移する際のタグ表示
// 「/post?tag=news」の様なurl表示ではなく、post/tag/newsの様な表示をしたい。
// その為、whereでアルファベットだけを取得して表示させる。
Route::get('posts/tag/{tagSlug}', 'PostController@index')->where('tagSlug', '[a-z]+')->name('posts.index.tag');
