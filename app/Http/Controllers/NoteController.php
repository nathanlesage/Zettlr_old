<?php

namespace App\Http\Controllers;

use Validator;

use App\Note;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// For rendering the markup within the view
use GrahamCampbell\Markdown\Facades\Markdown;

class NoteController extends Controller
{
	/**
     * Create a new controller instance.
     * Use "auth" middleware.
     *
     * @return void
     */
    public function __construct()
    {
    	// Require the user to be logged in
    	// for every action this controller does
        $this->middleware('auth');
    }
    
    public function home() {
        // For home just output a welcome page
        // TODO: Add a general settings pane here
        // views/main.blade.php
        return view('main');
    }
    
    public function index() {
        // For index output a list of all notes
        // views/notes/list.blade.php
        
        //$notes = Note::all();
        $notes = Note::get(['title', 'id']);
        
        return view('notes.list', ['notes' => $notes]);
    }
    
    public function getCreate() {
        // Display form to create a new note
        return view('notes.create');
    }
    
    public function postCreate(Request $request) {
        // Insert a note into the db
        
         $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect('/notes/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $note = new Note;
        $note->title = $request->title;
        $note->content = $request->content;
        
        $note->save();
        
        // Now redirect to note create as the user
        // definitely wants to add another note.
        return redirect(url('/notes/create'));
    }
    
    public function delete($id) {
    	try
    	{
    		$note = Note::findOrFail($id);
    	}
    	catch(ModelNotFoundException $e)
    	{
    		// Didn't find the note? Tell the user.
    		return redirect('/notes/index')
    			->withErrors(['No note with specified ID found.']);
    	}
    	
    	$note->delete();
    	
    	return redirect(url('/notes/index'));
    }
}
