<?php

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
Route::get('info',function(){
    phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('videos/{video}', 'VideoController@show');
Route::put('videos/{video}','VideoController@updateViews');
Route::put('videos/{video}/update','VideoController@update')->middleware('auth')->name('videos.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('channels', 'ChannelController');

Route::middleware(['auth'])->group(function(){
    Route::post('votes/{video}/{type}','VoteController@vote');
    Route::resource('channel/{channel/subscriptions','SubscriptionController')->only(['store','destroy']);
    Route::get('channels/{channel}/videos','UploadVideoController@index')->name('channel.upload');
    Route::post('channels/{channel}/videos','UploadVideoController@store');
});