<?php

namespace App\Http\Controllers;

use App\Models\chat_user;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function getChatMessages($chatId){
        return DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->join('users as us', 'cu.user_id', '=', 'us.id')
            ->where('cu.chat_id', '=', $chatId)
            ->select('m.message', 'us.name', 'm.created_at', 'us.id as user_id')
            ->orderBy('m.created_at')
            ->get();
    }


    public function  insert_message($chat_user_id, $msg){
        DB::table('messages')->insert([
            'chat_user_id' => $chat_user_id,
            'message' => $msg,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }


    public  function take_chat_user_id($chat_id){
        return DB::table('chat_user as cu')
            ->where('cu.chat_id', '=', $chat_id)
            ->where('cu.user_id', '=', Auth::user()->id)
            ->select('id as chat_user_id')
            ->first()->chat_user_id;
    }


    public function  delete_chat_history($chat_id){
        DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->where('cu.chat_id', '=', $chat_id)
            ->select('m.*', 'cu.id', 'cu.user_id', 'cu.chat_id')
            ->orderBy('m.created_at')
            ->delete();
    }


    public function get_matched_chat_id($id){
        return DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::user()->id)
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.chat_id as chat_id')
            ->first()->chat_id;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index($id, $msg = null)
    {
        if (empty($msg)){
            return 'emtpy';
        }

        $chatId = $this->get_matched_chat_id($id);

        if ($msg == "delete"){
            $this->delete_chat_history($chatId);
        } else{
            $chat_user_id = $this->take_chat_user_id($chatId);
            $this->insert_message($chat_user_id, $msg);
        }

        return $this->getChatMessages($chatId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function create($room_id=null, $msg=null)
    {
        if (empty($msg)){
            return 'emtpy';
        }

        $chat_user_id = $this->take_chat_user_id($room_id);
        $this->insert_message($chat_user_id, $msg);
        return $this->getChatMessages($room_id);

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
