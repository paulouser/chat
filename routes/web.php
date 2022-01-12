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


require __DIR__.'/auth.php';

Route::get('/chat/{id}', 'App\Http\Controllers\ChatController@index')->name('chat');
