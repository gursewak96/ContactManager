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
*/

Route::middleware('auth:api')->group(function () {
   
    Route::get('/birthdays',"BirthdayController@index");
    Route::get('/contacts',"ContactsController@index");
    Route::post("/contacts","ContactsController@store");
    Route::patch('/contacts/{contact}',"ContactsController@update");
    Route::get('/contacts/{contact}',"ContactsController@show");
    Route::delete('/contacts/{contact}',"ContactsController@delete");
    
});


