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
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/',     'AppController@home');
    Route::get('/home', 'AppController@home');

    // Notes routes
    Route::get ('notes/index',                  'NoteController@index');
    Route::get ('notes/create/{outlineId?}',    'NoteController@getCreate');
    Route::post('notes/create',                 'NoteController@postCreate');
    Route::get ('notes/edit/{id}',              'NoteController@getEdit');
    Route::post('notes/edit/{id}',              'NoteController@postEdit');
    Route::get ('notes/show/{id}',              'NoteController@show');
    // TODO: Not used right now, everything done via Ajax Controller
    Route::get('notes/delete/{id}',             'NoteController@delete');

    // Outlines routes
    Route::get('outlines/',             'OutlineController@index');
    Route::get('outlines/create',       'OutlineController@getCreate');
    Route::post('outlines/create',      'OutlineController@postCreate');
    Route::get('outlines/show/{id}/{export?}',    'OutlineController@show');
    Route::get('outlines/edit/{id}',    'OutlineController@getEdit');
    Route::post('outlines/edit/{id}',   'OutlineController@postEdit');
    Route::get('/outlines/delete/{id}', 'OutlineController@delete');

    // Tags routes
    Route::get('/tags/index',       'TagController@index');
    Route::get('/tags/show/{id}',   'TagController@show');
    Route::get('/tags/delete/{id}', 'TagController@delete');

    // References routes
    Route::get('/references/index',         'ReferenceController@index');
    Route::get('/references/create',        'ReferenceController@getCreate');
    Route::post('/references/create',       'ReferenceController@postCreate');
    Route::get('/references/edit/{id}',     'ReferenceController@getEdit');
    Route::post('/references/edit/{id}',    'ReferenceController@postEdit');
    Route::get('/references/delete/{id}',   'ReferenceController@delete');
    Route::get('/references/import', 'ReferenceController@getImport');
    Route::get('/references/import/confirm', 'ReferenceController@getConfirm');

    // Trail routes
    // Deactivated for always killing the dev server
    Route::get('/trails', 'TrailController@index');

    // Importer functions
    Route::get('/import',           'ImportController@getImport');
    Route::post('/import/confirm',  'ImportController@postImport');
    Route::post('/import/finish',   'ImportController@insertImport');

    // Settings controls
    Route::get('/settings',     'AppController@getSettings');
    Route::post('/settings',    'AppController@postSettings');

    // Ajax routes
    Route::get('/ajax/note/delete/{id}',        'AjaxController@getDeleteNote');
    Route::get('/ajax/note/search/{term}',      'AjaxController@getNoteSearch');
    Route::get('/ajax/note/{id}/{raw?}',        'AjaxController@getNoteContents');
    Route::post('/ajax/note/update',            'AjaxController@postUpdateNote');

    Route::get('/ajax/tag/search/{term}',       'AjaxController@getTagSearch');

    Route::get('/ajax/reference/search/{term}', 'AjaxController@getReferenceSearch');

    Route::get('/ajax/link/{id1}/with/{id2}',   'AjaxController@getLinkNotes');
    Route::get('/ajax/unlink/{id1}/from/{id2}', 'AjaxController@getUnlinkNotes');

    Route::get(
        '/ajax/outline/attach/{outlineID}/{attachmentType}/{requestContent}/{index}/{type?}',
        'AjaxController@getOutlineAttach'
    );
    Route::get(
        '/ajax/changeindex/{type}/{elementId}/{outlineId}/{newIndex}',
        'AjaxController@getChangeIndex'
    );
    Route::get(
        '/ajax/outline/detach/{outlineId}/{noteId}',
        'AjaxController@getOutlineDetachNote'
    );
    Route::get(
        '/ajax/outline/remove/{outlineId}/{customId}',
        'AjaxController@getOutlineRemoveCustom'
    );
    // Ajax handler for dropzone.js
    Route::post('/ajax/import/collect', 'AjaxController@collect');
});
