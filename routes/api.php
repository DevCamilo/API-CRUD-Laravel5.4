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

// Capacitaciones
Route::get('TrainingShow', 'TrainingAPI@show');
Route::post('TrainingCreate', 'TrainingAPI@create');
Route::put('TrainingUpdate', 'TrainingAPI@update');
Route::put('TrainingDelete', 'TrainingAPI@delete');

// Usuarios
Route::get('UserShow', 'UserAPI@show');
Route::post('UserLogin', 'UserAPI@login');
Route::post('UserCreate', 'UserAPI@create');
Route::put('UserUpdate', 'UserAPI@update');
Route::put('UserDelete', 'UserAPI@delete');


