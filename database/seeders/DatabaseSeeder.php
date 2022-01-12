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
        for ($i = 1; $i < 3; ++$i) {
//            DB::table('users')->insert([
//                'name' => Str::random(10),
//                'email' => Str::random(10) . '@gmail.com',
//                'password' => Hash::make('password'),
//            ]);

//            DB::table('chats')->insert([
//                'id' => $i,
//                'name' => 'chat_name'.$i,
//                'type' => true,
//            ]);

//            DB::table('chat_user')->insert([
//                "id" => $i,
//                'user_id' => $i,
//                'chat_id' => $i,
//                'created_at' => date("Y-m-d H:i:s"),
//            ]);

//            DB::table('messages')->insert([
//                'chat_user_id' => 1,
//                'message' => 'Hello user ',
//                'created_at' => date("Y-m-d H:i:s"),
//            ]);
        }

        // \App\Models\User::factory(10)->create();
    }
}
