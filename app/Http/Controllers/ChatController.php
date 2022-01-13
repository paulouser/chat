<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\chat_user;
use App\Models\message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Result;
use function PHPUnit\Framework\isEmpty;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $result1 = DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::user()->id)
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.id as chat_user_id', 'cu1.chat_id', 'cu1.user_id', 'cu2.user_id', 'ch.type')
            ->first();

        $result2 = DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', $id)
            ->where('cu2.user_id', '=', Auth::user()->id)
            ->select('cu1.id as chat_user_id', 'cu1.chat_id', 'cu1.user_id', 'cu2.user_id', 'ch.type')
            ->first();

        $chat_user1 = 0;
        $chat_user2 = 0;
        $is_match = false;
        if (!empty($result1) and !empty($result2)) {
            $is_match = true;
            $new_chat_id = $result1->chat_id;
            $chat_user1 = $result1->chat_user_id;
            $chat_user2 = $result2->chat_user_id;
        }

        if (!$is_match) {
            // create chat item
            $new_chat_id = DB::table('chats')->insertGetId([
                'name' => Auth::user()->name . "'s and " . DB::table('users')->where('id', $id)->pluck('name')->first() . " 's chat",
                'type' => true
            ]);

            // create 2 chat_user items (auth:id clicked:id)
            $chat_user1 = DB::table('chat_user')->insertGetId([
                'chat_id' => $new_chat_id,
                'user_id' => Auth::user()->id,
            ]);
            $chat_user2 = DB::table('chat_user')->insertGetId([
                'chat_id' => $new_chat_id,
                'user_id' => $id,
            ]);
        }

        $messages = DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->where('cu.chat_id', '=', $new_chat_id)
            ->select('m.*', 'cu.*')
            ->orderBy('m.created_at')
            ->get();
        return $messages;

        // clear the message history
        // when loading messages incoming and outcoming will shown

        // if auth:user typing the message then
        // add the message with auth:id in message table
        // after empty message history and load again

}
//        db query
//        return query result
//        return "selected id is -> ".$id.'<br>my id is '.Auth::id();

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(chat $chat)
    {
        //
    }
}
