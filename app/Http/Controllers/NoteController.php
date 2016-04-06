<?php

namespace App\Http\Controllers;

use Validator;

use App\Note;
use App\Tag;
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
    
    public function show($id) {
    	$note = Note::find($id);
    	// Only with this statement does he catch the tags!
    	$note->tags;
    	
    	return view('notes.show', ['note' => $note]);
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
        
        // Now fill the join table
        
        // for each tag, search, and, if it does not exist, create it
        foreach($request->tags as $tagname)
        {
        	$tag = Tag::firstOrCreate(["name" => $tagname]);
        	$note->tags()->attach($tag->id);
        }
        
        // Now redirect to note create as the user
        // definitely wants to add another note.
        return redirect(url('/notes/create'));
    }
    
    public function getEdit($id) {
    	$note = Note::find($id);
    	$note->tags;
    	return view('notes.edit', ['note' => $note]);
    }
    
    public function postEdit(Request $request, $id) {
    	// Update a note
        
         $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect('/notes/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        // First add any potential new tags to the database.
        // And also attach them if not done yet
        $tagIDs;
        foreach($request->tags as $tagname)
        {
        	$tag = Tag::firstOrCreate(["name" => $tagname]);
        	//if(!$note->tags->contains($tag->id))
        		//$note->tags()->attach($tag->id);
        	// Also add the tags to our array
        	$tagIDs[] = $tag->id;
        }
        
        // Get the note
        $note = Note::find($id);

        // Sync, i.e. remove no longer existent tags and add new tags
        $note->tags()->sync($tagIDs);
        
        // Update
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();
        
        
        // Now redirect to note create as the user
        // definitely wants to add another note.
        return redirect(url('/notes/show/'.$id));
        
        // Now fill the join table
        
        // for each tag, search, and, if it does not exist, create it
        foreach($request->tags as $tagname)
        {
        	$tag = Tag::firstOrCreate(["name" => $tagname]);
        	$note->tags()->attach($tag->id);
        }
        
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
