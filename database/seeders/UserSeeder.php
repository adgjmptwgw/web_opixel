<?php

namespace Database\Seeders;

// DBサファードを用いる際は下記追記
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'yamada',
                'email' => 'yamada@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'tanaka',
                'email' => 'tanaka@example.com',
                'email_verified_at' => now(),
                'password' => \Hash::make('123456789'),
                // 'role' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
