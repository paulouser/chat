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
//\
//            DB::table('chats')->insert([
//                'id' => 12,
//                'name' => 'second_room_chat',
//                'type' => false,
//            ]);

//            DB::table('chat_user')->insert([
//                "id" => 9,
//                'user_id' => 4,
//                'chat_id' => 3,
//                'created_at' => date("Y-m-d H:i:s"),
//            ]);

//        DB::table('chat_user')->where('id', 3)->update(['type' => false]);
//        DB::table('chats')->where('type', false)->delete();
//        DB::table('chats')->where('type', true)->delete();
//        DB::table('users')->delete();
//        DB::table('messages')->delete();
//            DB::table('messages')->insert([
//                'chat_user_id' => 216,
//                'message' => 'new group message for 216 chat_user_id and  224 chatId',
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
