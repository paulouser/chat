<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\chat_user;
use App\Models\message;
use App\Models\User;
use App\Providers\FunctionsServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use mysql_xdevapi\Result;
use function PHPUnit\Framework\isEmpty;

class ChatController extends Controller
{
    public function getChatMessages($chatId){
        return DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->join('users as us', 'cu.user_id', '=', 'us.id')
            ->where('cu.chat_id', '=', $chatId)
            ->select('m.message', 'us.name', 'm.created_at', 'us.id as user_id', 'us.img_path')
            ->orderBy('m.created_at')
            ->get();
    }


    public function createChat($id){
        $chatId = DB::table('chats')->insertGetId([
            'name' => Auth::user()->name . "'s and " . DB::table('users')->where('id', $id)->pluck('name')->first() . " 's chat",
            'type' => true,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        // create 2 chat_user items (auth:id clicked:id)
        DB::table('chat_user')->insert([
            'chat_id' => $chatId,
            'user_id' => Auth::user()->id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        DB::table('chat_user')->insert([
            'chat_id' => $chatId,
            'user_id' => $id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        return $chatId;
    }


    public function getChatId($id){
        return DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::id())
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.chat_id as chat_id')
            ->first();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index($id=null)
    {
        if (!empty($this->getChatId($id))){
            $chatId = $this->getChatId($id)->chat_id;
        }else{
            $chatId = $this->createChat($id);
        }

        return $this->getChatMessages($chatId);
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
