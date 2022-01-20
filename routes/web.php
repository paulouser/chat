<?php

use App\Models\chat;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::all();
    return view('dashboard', ['users' => $users]);
})->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';

Route::get('/chat/{id}', 'App\Http\Controllers\ChatController@index')->name('chat');


Route::get('/messages/{id}/{msg?}', 'App\Http\Controllers\MessageController@index')
    ->name('message')
    ->where('id', '[0-9]+');

Route::get('/room/{room_id?}/{msg?}', 'App\Http\Controllers\MessageController@create')->name('room');


Route::get('/rooms/{roomId?}', 'App\Http\Controllers\ChatUserController@index')->name('rooms');
Route::get('/chat_user/{chat_name?}', 'App\Http\Controllers\ChatUserController@create')->name('chat_user');

Route::get('/add_room/{room_name?}', 'App\Http\Controllers\RoomsController@index')->name('rooms');

Route::get('/getmessages/{roomId}', 'App\Http\Controllers\UserController@index')->name('user');
Route::get('/checking/{roomId}', 'App\Http\Controllers\UserController@create')->name('user');
