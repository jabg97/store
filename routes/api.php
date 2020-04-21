<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('p2p/sync', 'PlaceToPayController@sync')->name('p2p.sync');
Route::get('p2p/update/{id}', 'PlaceToPayController@update')->name('p2p.update');
Route::put('p2p/session/{id}', 'PlaceToPayController@session')->name('p2p.session');
