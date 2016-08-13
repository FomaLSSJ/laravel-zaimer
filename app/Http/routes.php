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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['prefix' => '/'], function() {
    Route::group(['prefix' => '/dashboard'], function() {
        Route::get('/', ['middleware' => 'auth', 'uses' => 'HomeController@getDashboard']);
        Route::get('/transfer', ['middleware' => 'auth', 'uses' => 'HomeController@getTransfer']);
        Route::post('/transfer', ['middleware' => 'auth', 'uses' => 'HomeController@postTransfer']);
    });
});

Route::get('/home', 'HomeController@index');
