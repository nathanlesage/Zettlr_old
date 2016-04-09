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
    
    public function getNoteSearch($term, $operator = "AND")
    {
    	// TODO: implement a "good" fulltext search.
    	// $operator: can be any of the following values
    	// "OR": find any word of $term (divided by spaces)
    	// "AND": results must contain all words in $term at any position
    	// "EXACT": results must contain the exact $term
    	/* Deactivated because it broke the system
    	switch($operator)
    	{
    		case "OR":
    			// First divide the search terms
    			$terms = explode(" ", $term);
    			// Then build the query.
    			// First get an empty query to be filled.
    			$query = Note::query();
    			// Now do a foreach loop of all terms
    			foreach($terms as $t)
    			{
    				$query->where('', 'LIKE', '%'.$t.'%');
    			}
    			break;
    		case "AND":
    			// First divide the search terms
    			$terms = explode(" ", $term);
    			// SELECT title, content, id FROM TABLE notes WHERE (title LIKE $t[0] AND title LIKE $t[1]) OR WHERE (content LIKE $t[0] AND content LIKE $t[1])
    			
    			$notes = Note::orWhere(function($query) use($terms) {
    				foreach($terms as $t)
    					$query->where('title', 'LIKE', $t);
    			})->orWhere(function($query) use($terms) {
    				foreach($terms as $t)
    					$query->where('content', 'LIKE', $t);
    			})->get();
    			break;
    		case "EXACT":
    			// Easy piece of cake:
    			$notes = Note::where('content', 'LIKE', '%'.$term.'%')->get(['content', 'title', 'id']);
    		break;
    	}*/
    	
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
}
