<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function generateAllRoomChats(){
        return DB::table('chats')
            ->where('chats.type','=',false)
            ->orderBy('chats.created_at')
            ->get();
    }

    public function createRoomChat($chat_name){
        $duplicate_name = chat::where('name', '=', $chat_name)->first();
        if ($duplicate_name == null and !empty($chat_name)){
            // there are no duplicate name's
            DB::table('chats')->insert([
                'name' => $chat_name,
                'type' => false,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }
    }

    public function generate_friends_list(){
//        dd('inside');
        return DB::table('chat_user as cu1')
            ->join('chats as ch', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->join('users as us', 'us.id', '=', 'cu2.user_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::id())
//            ->where('cu2.user_id', '<>', 'cu1.user_id')
            ->select('us.id', 'us.name', 'us.email', 'us.img_path', 'us.created_at')
            ->orderBy('us.created_at')
            ->get();
    }

    public function createChat($id){
        $chatId = DB::table('chats')->insertGetId([
            'name' => Auth::user()->name . "'s and " . DB::table('users')->where('id', $id)->pluck('name')->first() . " 's chat",
            'type' => true
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

    function generateMatchingList($search_message){
        return DB::table('users')
            ->where('users.name', 'like', $search_message.'%')
            ->select('users.*')
            ->orderBy('users.created_at')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index($search_message)
    {
        $is_any_matching = true;
        $matching_users_list = $this->generateMatchingList($search_message);
        if (empty($matching_users_list)){
            $is_any_matching = false;
        }
        return array('list' => $matching_users_list, 'status' => $is_any_matching);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return false
     */
    public function create($friend_id)
    {
        if (empty($this->get_matched_chat_id($friend_id))){
            $this->createChat($friend_id);
            return true;
        }
        return false;
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
     * @return array
     */
    public function show()
    {
        $friend_list =  $this->generate_friends_list();

        $this->createRoomChat('General');
        $this->createRoomChat('Other');

        $all_rooms = $this->generateAllRoomChats();

        return array('friend_list' => $friend_list, 'all_rooms' => $all_rooms);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
