<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Outline;
use App\Tag;
use App\Reference;

class OutlineController extends Controller
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

    public function index()
    {
        // ToDo: Display list of all outliners
        $outlines = Outline::all();

        return view('outlines.list', ['outlines' => $outlines]);
    }

    public function show($id)
    {
      // Take the id and output it (for now)
      try {
        $outline = Outline::findOrFail($id);
      } catch (ModelNotFoundException $e) {
        return redirect('outlines')->withErrors(['message', 'Could not find outline.']);
      }

      $outline->tags;
      $outline->references;

      // Then get all relationships
      $attachedNotes = $outline->notes;
      // Save indices
      foreach($attachedNotes as $note)
      {
        // Our view won't be able to determine the type of the element
        $note->objType = 'note';
        $note->index = $note->pivot->index;
      }

      $attachedCustoms = $outline->customFields;
      foreach($attachedCustoms as $field)
        $field->objType = 'custom';

      // Set the keyBy ID for both attach-collections
      // to make it able to "forget" all moved items.
      $attachedNotes->keyBy('id');
      $attachedCustoms->keyBy('id');

      // Now shuffle them into the right order into a new array
      $attachedElements = new Collection();
      // IMPORTANT: Index is 1-based!
      for($i = 0; $i < (count($attachedNotes)+count($attachedCustoms)); $i++)
      {
        foreach($attachedNotes as $note)
          if($note->index == ($i+1))
          {
            $attachedElements->push($note);
            $attachedNotes->pull($note->id);
          }

        foreach($attachedCustoms as $field)
          if($field->index == ($i+1))
          {
            $attachedElements->push($field);
            $attachedCustoms->pull($field->id);
          }
      }

      // Do we have remaining notes or custom fields left? Attach them at the end
      // The indices will be updated the next time anything is added, removed or moved.
    /*  if(count($attachedNotes) > 0)
        foreach($attachedNotes as $note)
          $attachedElements->push($note);

          if(count($attachedCustoms) > 0)
            foreach($attachedCustoms as $field)
              $attachedElements->push($field);*/

      return view('outlines.show', compact('outline', 'attachedElements'));
    }

    public function getCreate()
    {
      // Simply return the view
      return view('outlines.create');
    }

    public function postCreate(Request $request)
    {
      $validator = Validator::make($request->all(), [
         'name' => 'required|max:255',
         'description' => 'min:3|max:400'
     ]);

     if ($validator->fails()) {
         return redirect('/outlines/create')
                     ->withErrors($validator)
                     ->withInput();
     }
     // Validator passed? Then create.
     $outline = new Outline;
     $outline->name = $request->name;
     $outline->description = $request->description;
     $outline->save();

     foreach($request->tags as $tagname)
     {
       $tag = Tag::firstOrCreate(["name" => $tagname]);
       $outline->tags()->attach($tag->id);
     }

     foreach($request->references as $referenceId)
     {
         try {
           $ref = Reference::findOrFail($referenceId);
           // If this line is executed the model exists
           $outline->references()->attach($ref->id);

         } catch (ModelNotFoundException $e) {
           // Do nothing
         }
     }

      // Lastly, redirect to the outliner just created to let the user
      // fill it with input
      // return redirect('outlines/show/'.$outline->id);
      // For now let's add the user some notes
      return redirect('notes/create/'.$outline->id);
    }

    public function getEdit($id)
    {
        if(!$id || $id <= 0)
          return redirect('outlines/create')->withInput();

        $outline = Outline::find($id);
        $outline->tags;

        return view('outlines.edit', ['outline' => $outline]);
    }

    public function postEdit(Request $request, $id)
    {
      if(!$id || $id <= 0)
        return redirect('outlines/create')->withInput();

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

      $outline = Outline::find($id);


      // Sync, i.e. remove no longer existent tags and add new tags
      $outline->tags()->sync($tagIDs);

      $outline->name = $request->name;
      $outline->description = $request->description;
      $outline->save();

      return redirect(url('/outlines/show/'.$id));
    }
}
