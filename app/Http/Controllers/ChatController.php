<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Canal;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('Pages.Chat',["id" => "1"]);
    }
    public function chat($id){
        $chats = Canal::pluck("id");
        if(!$chats->contains($id)){
            return redirect()->route('dashboard');
        }
        $user = Auth::user();
        $chat = Canal::all();
        //$chatsuser = $chat->users()->id;
        //dd($chatsuser.$user->id);
        /*if(!$chatsuser->contains($user->id)){
            return redirect()->route('dashboard');
        }*/
        //dd("$id");
        return view('Pages.Chat',["id" => $id,"name"=>$chat->find($id)->name]);
    }
    public function ChooseChat(){

        $canais = Canal::pluck('name',"id");
        return view('Pages.Channels',["canais" => $canais]);
    }

    public function test(Request $request){
        return redirect()->back()->with('success', 'Chat criado com sucesso!');
    }

    public function criarchat(Request $request){

        $canal = new Canal();
        $canal->name = $request->nomechat;
        $canal->save();
        return redirect()->back()->with('success', 'Chat criado com sucesso!');
    }
    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message'),$request->get('user'),"1"))->toOthers();


        return view('components.RecivedMessageItem', ['message' => $request->get('message'),"user"=>$request->get('user')]);
    }

    public function receive(Request $request)
    {

        return view('components.SendedMessage', ['message' => $request->get('message'), "user"=>$request->get('user')]);
    }
    public function inscrever(Request $request)
{

    if (!Auth::check()) {
        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    // Obtenha o ID do canal da solicitação
    $canalId = $request->input('canal_id');

    // Insira a lógica para inscrever o usuário no canal aqui
    $usuario = Auth::user();
    $usuario->canals->attach($canalId);

    return response()->json(['success' => 'Usuário inscrito com sucesso no canal']);
}
}
