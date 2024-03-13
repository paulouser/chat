<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', 'App\Http\Controllers\ChatController@ChooseChat')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



    Route::get('/{id}', 'App\Http\Controllers\ChatController@chat');
    Route::post('/broadcast', 'App\Http\Controllers\ChatController@broadcast');
    Route::post('/receive', 'App\Http\Controllers\ChatController@receive');
    Route::post('/criarchat', 'App\Http\Controllers\ChatController@criarchat')->name("criarchat");




/*Route::prefix('/test2')->group(function () {
    Route::get('/', 'App\Http\Controllers\PusherController@index');

Route::post('/broadcast', 'App\Http\Controllers\PusherController@broadcast');
Route::post('/receive', 'App\Http\Controllers\PusherController@receive');
});

Route::get('/test', 'App\Http\Controllers\Controller@index');*/

require __DIR__.'/auth.php';
