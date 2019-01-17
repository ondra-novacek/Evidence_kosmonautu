<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List cosmonauts
Route::get('cosmonauts', 'CosmonautController@index');

// List single cosmonaut
Route::get('cosmonaut/{id}', 'CosmonautController@show');

// Create new article
Route::post('cosmonaut', 'CosmonautController@store');

// Update cosmonaut
Route::put('cosmonaut', 'CosmonautController@store');

// Delete cosmonaut
Route::delete('cosmonaut/{id}', 'CosmonautController@destroy');