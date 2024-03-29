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

Route::post('/register/into_season','App\Http\Controllers\SeasonController@register_into_season');

Route::get('/register/season','App\Http\Controllers\SeasonController@register_season');

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

Route::get('/soccer/ban/{id}', 'App\Http\Controllers\SoccerController@ban');

Route::get('/soccer/unban/{id}', 'App\Http\Controllers\SoccerController@unban');
 
Route::get('/soccer/delete/{id}', 'App\Http\Controllers\SoccerController@delete');


//Match route
Route::get('/match/{id}', 'App\Http\Controllers\MatchController@index');
//Get list team filter by season
Route::get('/match/listteam/{id}', 'App\Http\Controllers\MatchController@list_team_season');

Route::post('/match/add', 'App\Http\Controllers\MatchController@add');

Route::get('/match/edit/{id}', 'App\Http\Controllers\MatchController@edit_soccer');

Route::post('/match/update/{id}', 'App\Http\Controllers\MatchController@update');

Route::get('/match/delete/{id}', 'App\Http\Controllers\MatchController@delete');

//Registration Route
Route::get('/register', 'App\Http\Controllers\RegistrationFormController@index');

Route::get('/register/accept/{id}', 'App\Http\Controllers\RegistrationFormController@accept');

Route::get('/register/refuse/{id}', 'App\Http\Controllers\RegistrationFormController@refuse');

//Detailschedule route
Route::get('/match/detailschedule/{id}', 'App\Http\Controllers\MatchController@detailmatch');

Route::post('/match/detailschedule/add', 'App\Http\Controllers\MatchController@add_detailmatch');

Route::get('/match/detailschedule/delete/{id}', 'App\Http\Controllers\MatchController@delete_detailmatch');

//user route
Route::post('/login', 'App\Http\Controllers\UserController@login');

Route::post('/register', 'App\Http\Controllers\UserController@register');

Route::post('/create_team/{id}', 'App\Http\Controllers\UserController@create_team');

Route::get('/user', 'App\Http\Controllers\UserController@index');

Route::get('/user/edit/{id}', 'App\Http\Controllers\UserController@edit_user');

Route::post('/user/update/{id}', 'App\Http\Controllers\UserController@update');







