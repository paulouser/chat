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

Route::get('/chat_user/{chat_name}', 'App\Http\Controllers\ChatUserController@index')->name('chat_user');
