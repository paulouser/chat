<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getGeneralChatId(){
        return DB::table('chats')
            ->where('chats.name','=', 'General')
            ->first()->id;
    }

    public function getOtherChatId(){
        return DB::table('chats')
            ->where('chats.name','=', 'Other')
            ->first()->id;
    }

    public function insert_me_in_PredifinedRooms($general_chat_id, $other_chat_id){

        DB::table('chat_user')->insert([
            'user_id' => Auth::id(),
            'chat_id' => $general_chat_id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        DB::table('chat_user')->insert([
            'user_id' => Auth::id(),
            'chat_id' => $other_chat_id,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }

    public function generateRoomList(){
        return DB::table('chats as ch')
            ->join('chat_user as cu','ch.id','=','cu.chat_id')
            ->where('ch.type','=',false)
            ->where('cu.user_id','=',Auth::id())
            ->orderBy('ch.created_at')
            ->select('ch.*')
            ->get();
    }

    public function createPredefinedRoomChat($chat_name){
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
        return DB::table('chat_user as cu1')
            ->join('chats as ch', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->join('users as us', 'us.id', '=', 'cu2.user_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::id())
//            ->where('cu2.user_id', '<>', 'cu1.user_id')
            ->select('us.id', 'us.name', 'us.full_name', 'us.img_path', 'us.created_at')
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

    public function get_matched_chat($id){
        return DB::table('chats as ch')
            ->join('chat_user as cu1', 'ch.id', '=', 'cu1.chat_id')
            ->leftJoin('chat_user as cu2', 'cu1.chat_id', '=', 'cu2.chat_id')
            ->where('ch.type', '=', true)
            ->where('cu1.user_id', '=', Auth::id())
            ->where('cu2.user_id', '=', $id)
            ->select('cu1.chat_id as chat_id')
            ->first();
    }

    public function get_matched_room($roomId){
        return DB::table('chat_user as cu')
            ->join('chats as ch', 'ch.id','=', 'cu.chat_id')
            ->where('ch.type','=',false)
            ->where('cu.user_id','=', Auth::id())
            ->where('ch.id','=', $roomId)
            ->first();
    }

    public function addInRoom($roomId){
        DB::table('chat_user')->insert([
            'user_id' => Auth::id(),
            'chat_id' => $roomId,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }

    public function generateMatchingUsersList($search_message=null){
        if ($search_message == null){
            $search_message = '';
        }
        return DB::table('users')
            ->where('users.name', 'like', $search_message.'%')
            ->select('users.*')
            ->orderBy('users.created_at')
            ->get();
    }

    public function generateMatchingRoomsList($search_message){
        return DB::table('chat_user as cu')
            ->join('chats as ch','ch.id','=','cu.chat_id')
            ->where('ch.type', '=', false)
            ->where('ch.name', 'like', $search_message.'%')
            ->select('users.*')
            ->groupBy('ch.id')
            ->orderBy('ch.created_at')
            ->select('ch.*')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index($search_message=null)
    {
        $is_any_users_matching = true;
        $is_any_rooms_matching = true;

        $matching_users_list = $this->generateMatchingUsersList($search_message);
        $matching_rooms_list = $this->generateMatchingRoomsList($search_message);

        if (empty($matching_users_list)){
            $is_any_users_matching = false;
        }

        if (empty($matching_rooms_list)){
            $is_any_rooms_matching = false;
        }

        return array('users_list' => $matching_users_list, 'rooms_list' => $matching_rooms_list, 'status1' => $is_any_users_matching, 'status2' => $is_any_rooms_matching);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return false
     */
    public function create($friend_or_room_id, $Type)
    {
        if ($Type == 'user'){
            if (empty($this->get_matched_chat($friend_or_room_id))){
                $this->createChat($friend_or_room_id);
                return 1;
            }
        }else if ($Type == 'room'){
            if (empty($this->get_matched_room($friend_or_room_id))){
//                $this->addInRoom($friend_or_room_id);
                return 2;
            }
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
     * @return array
     */
    public function show()
    {
        $friend_list =  $this->generate_friends_list();

        $this->createPredefinedRoomChat('General');
        $this->createPredefinedRoomChat('Other');

        // get General chat_id
        $general_chat_id = $this->getGeneralChatId();

        // get Other chat_id
        $other_chat_id = $this->getOtherChatId();

        // insert me in this chats
        $this->insert_me_in_PredifinedRooms($general_chat_id, $other_chat_id);

        $room_list = $this->generateRoomList();

        return array('friend_list' => $friend_list, 'room_list' => $room_list);
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
