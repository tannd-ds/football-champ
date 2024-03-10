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

Route::get('/team/{id}', 'App\Http\Controllers\TeamController@show_team');

Route::post('/team/add', 'App\Http\Controllers\TeamController@add');

Route::get('/team/edit/{id}', 'App\Http\Controllers\TeamController@edit_team');

Route::post('/team/update/{id}', 'App\Http\Controllers\TeamController@update');

Route::get('/team/delete/{id}', 'App\Http\Controllers\TeamController@delete');
//Soccer route
Route::get('/soccer', 'App\Http\Controllers\SoccerController@index');

Route::post('/soccer/add', 'App\Http\Controllers\SoccerController@add');

Route::get('/soccer/edit/{id}', 'App\Http\Controllers\SoccerController@edit_soccer');

Route::post('/soccer/update/{id}', 'App\Http\Controllers\SoccerController@update');

Route::get('/soccer/delete/{id}', 'App\Http\Controllers\SoccerController@delete');

//Match route
Route::get('/match/{id}', 'App\Http\Controllers\MatchController@index');
//Get list team filter by season
Route::get('/match/listteam/{id}', 'App\Http\Controllers\MatchController@list_team_season');

Route::post('/match/add', 'App\Http\Controllers\MatchController@add');

Route::get('/match/edit/{id}', 'App\Http\Controllers\MatchController@edit_soccer');

Route::post('/match/update/{id}', 'App\Http\Controllers\MatchController@update');

Route::get('/match/delete/{id}', 'App\Http\Controllers\MatchController@delete');