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

    public function get_matched_chat_id($id){
        return DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::id())
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.chat_id as chat_id')
            ->first();
    }

    public function getChatMessages($roomId){
        return DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->join('users as us', 'cu.user_id', '=', 'us.id')
            ->where('cu.chat_id', '=', $roomId)
            ->select('m.message', 'us.name', 'm.created_at', 'us.id as user_id', 'us.img_path')
            ->orderBy('m.created_at')
            ->get();
    }

    public function addInRoom($roomId){
        DB::table('chat_user')->insert([
            'chat_id' => $roomId,
            'user_id' => Auth::user()->id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
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
        return $chatId;
    }

    public function isChatExist($chat_name){
        $existing_chat = DB::table('chats')->where('name', '=', $chat_name)->first();
        if (empty($existing_chat)){
            return false;
        }else{
            return true;
        }
    }

    public function isParticipant($roomId){
        $exist = DB::table('chat_user')
            ->where('chat_id', '=', $roomId)
            ->where('user_id', '=', Auth::id())
            ->first();
        if (empty($exist)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index($roomId=null)
    {
        if (!$this->isParticipant($roomId)){
            $this->addInRoom($roomId);
        }
        return $this->getChatMessages($roomId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|\Illuminate\Http\Response|object
     */
    public function create($chat_name=null)
    {
        if ($chat_name != null){
            $is_exist = $this->isChatExist($chat_name);
            if (!$is_exist){
                $roomId = $this->createRoomChat($chat_name);
                $this->addInRoom($roomId);
            }
            return DB::table('chats')->where('id', '=', $roomId)->first();
        }
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
     * @return array
     */
    public function show($friendId)
    {
        $matched_chat = $this->get_matched_chat_id($friendId);
        $messages = '';

        if (empty($matched_chat)){
            $this->createChat($friendId);
            $status = false;
        }else{
            $chatId = $matched_chat->chat_id;
            $messages = $this->getChatMessages($chatId);
            $status = true;
        }

        return array('messages' => $messages, 'status' => $status);
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
