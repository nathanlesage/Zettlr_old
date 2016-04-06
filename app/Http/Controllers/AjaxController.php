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
    	$tags = Tag::where('name', 'LIKE', '%'.$term.'%')->get(['name']);
    	
    	if(! $tags)
    	{
    		return response()->json(['message', 'No tags match your search term'], 404);
    	}
    	else
    	{
    		return $tags;
    	}
    }
}
