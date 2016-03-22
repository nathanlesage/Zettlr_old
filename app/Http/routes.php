<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Go to NoteController as standard index file
// TODO: Change to a single logon page (inside UserController)
Route::get('/', 'NoteController@home');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Group all note-related actions together
Route::group(['prefix' => 'notes'], function () {
    Route::get('index', 'NoteController@index');
    Route::get('create', 'NoteController@create');
    Route::post('create', 'NoteController@insertNote');
    Route::get('edit', 'NoteController@edit');
});

// Group all outline-related actions together
Route::group(['prefix' => 'outline'], function() {
    Route::get('/', 'OutlineController@index');
    Route::get('create', 'OutlineController@create');
    Route::get('edit', 'OutlineController@edit');
});

// Login functionality
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
