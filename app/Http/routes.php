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
// Route::get('/', 'NoteController@home');

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

// Login functionality
Route::group(['middleware' => 'web'], function () {
    Route::auth();

	// Redirect here if user is logged in
    Route::get('/', 'NoteController@index'); // show all notes TODO: redirect to notes/index
    Route::get('/home', 'NoteController@home'); // TODO: admin area
    
    Route::get ('notes/index',     'NoteController@index');
    
    Route::get ('notes/create',    'NoteController@getCreate');
    Route::post('notes/create',    'NoteController@postCreate');
    
    Route::get ('notes/edit/{id}', 'NoteController@getEdit');
    Route::post('notes/edit/{id}', 'NoteController@postEdit');
    
    Route::get ('notes/show/{id}', 'NoteController@show');
    // TODO: Not used right now, everything done via Ajax Controller
    Route::get('notes/delete/{id}', 'NoteController@delete');
    
    // Ajax routes
    Route::get('/ajax/note/delete/{id}', 'AjaxController@getDeleteNote');
    Route::get('/ajax/note/search/{term}', 'AjaxController@getNoteSearch');
    Route::get('/ajax/note/{id}', 'AjaxController@getNoteContents');
    Route::get('/ajax/tag/search/{term}', 'AjaxController@getTagSearch');
    Route::get('/ajax/link/{id1}/with/{id2}', 'AjaxController@getLinkNotes');
});

// Group all note-related actions together
Route::group(['prefix' => 'notes'], function () {
    
});

// Group all outline-related actions together
Route::group(['prefix' => 'outline'], function() {
    Route::get('/', 'OutlineController@index');
    Route::get('create', 'OutlineController@create');
    Route::get('edit', 'OutlineController@edit');
});




