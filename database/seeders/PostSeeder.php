<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // post.phpのprotected static function boot()にsavingがある為、シーダーのコマンド実行時にも、
        // savingの処理が実行されてエラーになる。(シーダーコマンド実行時にはログイン情報が取れないから)
        // その為、一時的に処理を止める為に\Event::fakeForを使う。
        \Event::fakeFor(function () {
         Post::factory()->count(50)->create();
         });
    }
}
