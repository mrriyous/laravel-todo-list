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

Route::get('/',['as'=>'todo.all','uses'=>'TodoController@index']);
Route::get('/todo/{id}',['as'=>'todo.get','uses'=>'TodoController@get']);
Route::post('/todo/add',['as'=>'todo.add','uses'=>'TodoController@insert']);