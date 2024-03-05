<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Season route
Route::get('/season', 'App\Http\Controllers\SeasonController@index');

Route::post('/season/add', 'App\Http\Controllers\SeasonController@add');

Route::get('/season/edit/{id}', 'App\Http\Controllers\SeasonController@edit_season');

Route::post('/season/update/{id}', 'App\Http\Controllers\SeasonController@update');

Route::get('/season/delete/{id}', 'App\Http\Controllers\SeasonController@delete');
// Team route
Route::get('/team', 'App\Http\Controllers\TeamController@index');
Route::post('/team/add', 'App\Http\Controllers\TeamController@add');