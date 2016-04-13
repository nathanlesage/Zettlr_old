<?php

namespace App\Http\Controllers;

use Validator;

use App\Note;
use App\Tag;
use App\Outline;
use App\Reference;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
    	// eager load Note with its tags
    	$note = Note::find($id);
    	$note->tags;
    	// does the note exist? If not, return error
    	if(!$note)
    		return redirect('notes/index')->withErrors(['message', 'That note does not exist!']);

    	// Get all note and their tags if the tag ID is in our tags-array
    	$tags = [];
    	foreach($note->tags as $tag)
    		$tags[] = $tag->id;

    	// That was fucking hard to write :x
    	$relatedNotes = Note::whereHas('tags', function($query) use($tags) {
    		$query->whereIn('tag_id', $tags);
    	})->get();

    	// Now remove this note from collection (to reduce inception level)
    	$relatedNotes = $relatedNotes->keyBy('id');
    	$relatedNotes->forget($note->id);

    	// Now we have all relatedNotes
    	// But they have ALL tags with them.
    	// We have to determine the relevancy manually
    	$maxCount = 0;
    	foreach($relatedNotes as $n)
    	{
    		// count all similar tags and write a count-attribute to the model
    		$count = 0;

    		foreach($n->tags as $t)
    			foreach($note->tags as $t2)
    				if($t->id == $t2->id) {
    					$count++;
    					break;
    				}

    		$n->count = $count;
    		// write current maxCount
    		if($count > $maxCount)
    			$maxCount = $count;
    	}

    	// Now we need to sort the relatedNotes by relevancy
    	//$relatedNotes = array_values(array_sort($relatedNotes, function($value) { return $value->count; }));
    	//array_multisort($relatedNotes, "SORT_DESC", );
    	$relatedNotes = Collection::make($relatedNotes)->sortBy(function($value) { return $value->count; }, SORT_REGULAR, true)->all();

    	// Now retrieve IDs and title of all linked notes
    	$linkedNotes = $note->notes;

    	return view('notes.show', ['note' => $note, 'relatedNotes' => $relatedNotes, 'maxCount' => $maxCount, 'linkedNotes' => $linkedNotes]);
    }

    public function getCreate($outlineId = 0) {
      if($outlineId > 0)
      {
        try {
          $outline = Outline::findOrFail($outlineId);
          // Eager load tags
          $outline->tags;
          // Display form to create a new note
          return view('notes.create', ['outline' => $outline]);
        } catch (ModelNotFoundException $e) {
          // Okay, obviously we don't have an outline. Just return the view.
          return view('notes.create', ['outline' => null]);
        }
      }
      // No outline? Just return the view.
      return view('notes.create', ['outline' => null]);
    }

    public function postCreate(Request $request) {
        // Insert a note into the db
        // New tags have ID = -1!

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
        // TODO: Check for no tags given
        foreach($request->tags as $tagname)
        {
        	$tag = Tag::firstOrCreate(["name" => $tagname]);
        	$note->tags()->attach($tag->id);
        }

        foreach($request->references as $referenceId)
        {
          try {
            Reference::findOrFail($referenceId);
            // If this line is executed the model exists
            $note->references()->attach($referenceId);

          } catch (ModelNotFoundException $e) {
            // Do nothing
          }
        }

        if($request->outlineId > 0)
        {
          $outline = Outline::find($request->outlineId);
          // Which index should we use? Of course the last.
          $noteIndex = count($outline->customFields) + count($outline->notes) + 1;
          // Attach to this outline
          $outline = Outline::find($request->outlineId)->notes()->attach($note, ['index' => $noteIndex]);
          return redirect(url('/notes/create/'.$request->outlineId));
        }

        // Now redirect to note create as the user
        // definitely wants to add another note.
        return redirect(url('/notes/create'));
    }

    public function getEdit($id) {
    	$note = Note::find($id);
    	$note->tags;
      $note->references;
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
        // TODO: check for no tags given
        foreach($request->tags as $tagname)
        {
        	$tag = Tag::firstOrCreate(["name" => $tagname]);
        	//if(!$note->tags->contains($tag->id))
        		//$note->tags()->attach($tag->id);
        	// Also add the tags to our array
        	$tagIDs[] = $tag->id;
        }
        // Same for references
        $referenceIDs;

        foreach($request->references as $referenceId)
        {
            try {
              $ref = Reference::findOrFail($referenceId);
              // If this line is executed the model exists
              $referenceIDs[] = $ref->id;

            } catch (ModelNotFoundException $e) {
              // Do nothing
            }
        }

        // Get the note
        $note = Note::find($id);

        // Sync, i.e. remove no longer existent tags and add new tags
        $note->tags()->sync($tagIDs);
        $note->references()->sync($referenceIDs);

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
