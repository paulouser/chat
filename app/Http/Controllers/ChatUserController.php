<?php

namespace App\Http\Controllers;

//use App\Models\message;
use App\Models\chat;
use App\Models\chat_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatUserController extends Controller
{
    public function getChatMessages($roomId){
            return DB::table('messages as m')
                ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
                ->where('cu.chat_id', '=', $roomId)
                ->select('m.*', 'cu.id', 'cu.user_id', 'cu.chat_id')
                ->orderBy('m.created_at')
                ->get();
    }

    public function createRoomChat($chat_name){
        $duplicate_name = chat::where('name', '=', $chat_name)->first();
        if ($duplicate_name == null and !empty($chat_name)){
            // there are no duplicate name's
            $chatId = DB::table('chats')->insertGetId([
                'name' => $chat_name,
                'type' => false,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }
    }

    public function addInRoom($roomId){
        DB::table('chat_user')->insert([
            'chat_id' => $roomId,
            'user_id' => Auth::user()->id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index($roomId=null)
    {
        $this->addInRoom($roomId);
        return $this->getChatMessages($roomId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($chat_name=null)
    {
        $this->createRoomChat($chat_name);
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
     * @param  \App\Models\chat_user  $chat_user
     * @return \Illuminate\Http\Response
     */
    public function show(chat_user $chat_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chat_user  $chat_user
     * @return \Illuminate\Http\Response
     */
    public function edit(chat_user $chat_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chat_user  $chat_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chat_user $chat_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chat_user  $chat_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(chat_user $chat_user)
    {
        //
    }
}
