<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function index()
    {
        return view('test2');
    }

    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message'),$request->get('user'),"1"))->toOthers();

        return view('broadcast', ['message' => $request->get('message'),"user"=>"yourself"]);
    }

    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message'), "user"=>$request->get('message')]);
    }
}

