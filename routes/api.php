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

Route::group(['middleware' => 'api','prefix' => 'auth', 'namespace' => 'App\Http\Controllers',], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'token'], function (){
    Route::get('/exercise2get/{data}', 'ExerciseController@exercise2get');
    Route::post('/exercise2post', 'ExerciseController@exercise2post');

    Route::get('/exercise3get/{id}/{data}', 'ExerciseController@exercise3get');
    Route::post('/exercise3post', 'ExerciseController@exercise3post');
});

Route::get('/exercise', 'App\Http\Controllers\ExerciseController@exercise');
Route::delete('/destroy/{id}', 'App\Http\Controllers\ExerciseController@destroy');
