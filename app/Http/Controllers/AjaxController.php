<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Note;
use App\Tag;

// For rendering the markup within the view
use GrahamCampbell\Markdown\Facades\Markdown;

/*
 * This controller is responsible
 * for handling all AJAX-Requests by the application.
 */
 
class AjaxController extends Controller
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
    
    // Fetch note contents via given ID
    public function getNoteContents($id)
    {
    	$note = Note::find($id);
    	$note->tags;
    		
    	if(! $note)
    	{
    		// Didn't find the note? Tell the app
    		return response()->json(['message', 'Not a valid note'], 404);
    	}
    	else
    	{
    		// Otherwise just return our complete note in JSON format
    		// Don't forget to parse the content to HTML
    		$note->content = Markdown::convertToHtml($note->content);
    		
    		return $note;
    	}
    }
    
    // Delete note
    public function getDeleteNote($id)
    {
    	$note = Note::find($id);
    	
    	if(! $note)
    	{
    		// Didn't find the note? Tell the app
    		return response()->json(['message', 'Not a valid note'], 404);
    	}
    	else
    	{
    		// Otherwise delete the note
    		$note->forceDelete();
    		return response()->json(['message', 'Note deleted successfully'], 200);
    	}
    }
    
    public function getTagSearch($term)
    {
    	// The "LIKE"-Statement in SQL just searches for the pattern
    	// anywhere in, at the beginning or the end of a term.
    	$tags = Tag::where('name', 'LIKE', '%'.$term.'%')->get(['name', 'id']);
    	
    	if(! $tags)
    	{
    		return response()->json(['message', 'No tags match your search term'], 404);
    	}
    	else
    	{
    		return $tags;
    	}
    }
    
    public function getNoteSearch($term)
    {
    	// TODO: implement a "good" fulltext search.
    	
    	$notes = Note::where('content', 'LIKE', '%'.$term.'%')->orWhere('title', 'LIKE', '%'.$term.'%')->get(['content', 'title', 'id']);
    	
    	// Do we have a search result?
    	if(! $notes)
    	{
    		return response()->json(['message', 'No search results'], 404);
    	}
    	else
    	{
    		foreach($notes as $note)
    		{
    			$note->content = substr($note->content, 0, 120)."&hellip;";
    		}
    		return $notes;
    	}
    }
    
    public function getLinkNotes($id1, $id2)
    {
    	if(($id1 <= 0) || ($id2 <= 0))
    		return response()->json(['message', 'Bad request: An ID was invalid'], 400);
    	
    	try
    	{
    		Note::findOrFail($id1);
    		Note::findOrFail($id2);
    	}
    	catch(ModelNotFoundException $e)
    	{
    		return response()->json(['message', 'Some ID did not belong to any note'], 404);
    	}
    	
    	// This note is the currently active note
    	$note = Note::find($id1);
    	$note2 = Note::find($id2);
    	
    	//  And it should be attached to this ID (and vice versa)
    	$note->notes()->attach($id2);
    	$note2->notes()->attach($id1);
    	
    	return response()->json(['message', 'Notes linked successfully'], 200);
    }
}
