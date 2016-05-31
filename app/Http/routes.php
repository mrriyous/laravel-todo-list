<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',['as' => 'todo.all','uses' => 'TodoController@index']);

Route::get('/todo/{id}',['as'=>'todo.get','uses'=>'TodoController@get']);

Route::post('/todo/insert',['as'=>'todo.insert','uses'=>'TodoController@insert']);
Route::post('/todo/update',['as'=>'todo.update','uses'=>'TodoController@update']);
Route::post('/todo/done',['as'=>'todo.done','uses'=>'TodoController@done']);