<?php

namespace Database\Seeders;

use App\Models\chat_user;
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
//        for ($i = 1; $i < 3; ++$i) {
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
//                "id" => 9,
//                'user_id' => 4,
//                'chat_id' => 3,
//                'created_at' => date("Y-m-d H:i:s"),
//            ]);

//        DB::table('chat_user')->where('id', 3)->update(['type' => false]);
//        DB::table('messages')->delete(3);
//            DB::table('messages')->insert([
//                'chat_user_id' => 2,
//                'message' => 'How are you? from 1 to 5',
//                'created_at' => date("Y-m-d H:i:s"),
//            ]);


//        DB::table('messages')->where('id', 5)->update(
//            [
//            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
//            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
//            ]);
        }
        // \App\Models\User::factory(10)->create();
//    }
}
