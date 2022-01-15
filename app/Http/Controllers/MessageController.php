<?php

namespace App\Http\Controllers;

use App\Models\chat_user;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index($id, $msg = null)
    {
        if (empty($msg)){
            return 'emtpy_message';
        }

        $get_matched_chat_id = DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::user()->id)
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.chat_id as chat_id')
            ->first();

        $chat_id = $get_matched_chat_id->chat_id;

        if ($msg == "delete"){
            DB::table('messages as m')
                ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
                ->where('cu.chat_id', '=', $chat_id)
                ->select('m.*', 'cu.id', 'cu.user_id', 'cu.chat_id')
                ->orderBy('m.created_at')
                ->delete();
        } else{
            $chat_user_id = DB::table('chat_user as cu')
                ->where('cu.chat_id', '=', $chat_id)
                ->where('cu.user_id', '=', Auth::user()->id)
                ->select('id as chat_user_id')
                ->first();

            DB::table('messages')->insert([
                'chat_user_id' => $chat_user_id->chat_user_id,
                'message' => $msg,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        }


        // getChatMessages($chatId)
        return DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->where('cu.chat_id', '=', $chat_id)
            ->select('m.*', 'cu.id', 'cu.user_id', 'cu.chat_id')
            ->orderBy('m.created_at')
            ->get();
    }

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
     * @param  \App\Models\message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(message $message)
    {
        //
    }
}
