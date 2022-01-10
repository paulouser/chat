<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; ++$i) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ]);

            DB::table('chats')->insert([
                'name' => Str::random(10),
                'type' => true,
            ]);

            DB::table('chat_user')->insert([
                'user_id' => 1,
                'chat_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ]);

            DB::table('messages')->insert([
                'chat_user_id' => 1,
                'message' => 'Hello world!',
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }

        // \App\Models\User::factory(10)->create();
    }
}
