<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getChatMessages($roomId): \Illuminate\Support\Collection
    {
        return DB::table('messages as m')
            ->leftJoin('chat_user as cu', 'm.chat_user_id', '=', 'cu.id')
            ->join('users as us', 'cu.user_id', '=', 'us.id')
            ->where('cu.chat_id', '=', $roomId)
            ->select('m.message', 'us.name', 'm.created_at', 'us.id as user_id')
            ->orderBy('m.created_at')
            ->get();
    }

    public function is_in_chat($roomId){
        $already_in_chat = DB::table('chat_user as cu')
            ->leftJoin('chats as ch', 'cu.chat_id', '=', 'ch.id')
            ->where('user_id', '=', Auth::id())
            ->where('chat_id', '=', $roomId)
            ->where('ch.type','=', false)
            ->first();
        if (empty($already_in_chat)){
            return false;
        }else{
            return true;
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index($roomId)
    {
        return array("messages"=>$this->getChatMessages($roomId), "status"=>$this->is_in_chat($roomId));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
