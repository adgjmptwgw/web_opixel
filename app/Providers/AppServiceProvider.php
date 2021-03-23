<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// ページナビゲーションを有効にする
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ページナビゲーションを有効にする
        Paginator::useBootstrap();

    }
}
