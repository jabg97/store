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

Route::get('/', 'StoreController@index')->name('index');

Route::resource(
    'store',
    'StoreController',
    [
    'only' => ['index'],
]
);

Route::resource(
    'order',
    'OrderController',
    [
        'except' => ['create'],
    ]
);

Route::get('order/create/{id}', 'OrderController@create')->name('order.create');
Route::get('order/table/{status?}', 'OrderController@table')->name('order.table');
Route::get('order/test/{id}', 'OrderController@test')->name('order.test');
