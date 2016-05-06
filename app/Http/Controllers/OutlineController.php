<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     *  Displays a list of all outlines
     *
     *  @return  Response
     */
    public function index()
    {
        // ToDo: Display list of all outliners
        $outlines = Outline::all();

        return view('outlines.list', ['outlines' => $outlines]);
    }

    /**
     *  Displays a single outline
     *
     *  @param   integer  $id  Outline id
     *
     *  @return  Response
     */
    public function show($id)
    {
        try {
            $outline = Outline::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('outlines')->withErrors(['message', 'Could not find outline.']);
        }

        // Eager load tags and references
        $outline->tags;
        $outline->references;

        // Then get all relationships
        $attachedNotes = $outline->notes;
        // Save indices
        foreach($attachedNotes as $note)
        {
            // Our view won't be able to determine the type of the element
            // Therefore create a new attribute that our view can relate to
            $note->objType = 'note';
            // Get the note index
            $note->index = $note->pivot->index;
        }

        // The index of custom fields is stored in the custom fields database,
        // so we don't need to get it specifically
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
        if((count($attachedNotes) <= 0) || (count($attachedCustoms) <= 0))
        {
            // If either array is empty, just insert it to the attached elements.
            if(count($attachedNotes) == 0)
            {
                $attachedElements = $attachedCustoms;
            }
            else {
                // And vice versa
                $attachedElements = $attachedNotes;
            }
        }
        else
        {
            // Shuffling only makes sense if both arrays are present.
            for($i = 0; $i < (count($attachedNotes)+count($attachedCustoms)); $i++)
            {
                foreach($attachedNotes as $note)
                {
                    if($note->index == ($i+1))
                    {
                        $attachedElements->push($note);
                        $attachedNotes->pull($i+1);
                    }
                }


                foreach($attachedCustoms as $field)
                {
                    if($field->index == ($i+1))
                    {
                        $attachedElements->push($field);
                        $attachedCustoms->pull($i+1);
                    }
                }
            }
        }

        return view('outlines.show', compact('outline', 'attachedElements'));
    }

    /**
     *  Display a form to insert a new outline
     *
     *  @return  Response
     */
    public function getCreate()
    {
        // Simply return the view
        return view('outlines.create');
    }

    /**
     *  Inserts a new outline into the database
     *
     *  @param   Request  $request
     *
     *  @return  Response
     */
    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3'
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

        if(count($request->tags) > 0)
        {
            foreach($request->tags as $tagname)
            {
                $tag = Tag::firstOrCreate(["name" => $tagname]);
                $outline->tags()->attach($tag->id);
            }
        }

        if(count($request->references) > 0)
        {
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
        }

        // For now let's add the user some notes
        return redirect('notes/create/'.$outline->id);
    }

    /**
     *  Displays a form to edit an outline
     *
     *  @param   integer  $id  Outline id
     *
     *  @return  Response
     */
    public function getEdit($id)
    {
        if(!$id || $id <= 0)
        return redirect('outlines/create')->withInput();

        $outline = Outline::find($id);
        $outline->tags;

        return view('outlines.edit', ['outline' => $outline]);
    }

    /**
     *  Updates an outline record in the database
     *
     *  @param   Request  $request
     *  @param   integer   $id       Outline id
     *
     *  @return  Response
     */
    public function postEdit(Request $request, $id)
    {
        if(!$id || $id <= 0)
        return redirect('outlines/create')->withInput();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3'
        ]);

        if ($validator->fails()) {
            return redirect('/outlines/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        // If everything passed let's edit!
        $outline = Outline::find($id);

        if(count($request->tags) > 0)
        {
            $tagIDs = [];

            foreach($request->tags as $tagname)
            {
                $tag = Tag::firstOrCreate(["name" => $tagname]);
                $tagIDs[] = $tag->id;
            }
            // Sync tag list
            $outline->tags()->sync($tagIDs);
        }
        else {
            // Sync with empty array to remove all
            $outline->tags()->sync([]);
        }

        if(count($request->references) > 0)
        {
            // Same for references
            $referenceIDs = [];

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

            $outline->references()->sync($referenceIDs);
        }
        else {
            // Sync with empty array to remove all
            $outline->references()->sync([]);
        }

        $outline->name = $request->name;
        $outline->description = $request->description;
        $outline->save();

        if($request->noteAction == 3) // Attach anything new
        {
            foreach($outline->notes as $note)
            {
                $note->references()->attach($outline->references);
                $note->tags()->attach($outline->tags);
            }
        }
        elseif($request->noteAction == 2) // Synchronize
        {
            foreach($outline->notes as $note)
            {
                $note->references()->sync($outline->references);
                $note->tags()->sync($outline->tags);
            }
        }

        return redirect(url('/outlines/show/'.$id));
    }

    /**
     *  Removes an outline, detaches its notes and removes its custom fields
     *
     *  @param   integer  $id  Outline id
     *
     *  @return  Response
     */
    public function delete($id)
    {
        try {
            $outline = Outline::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/outlines');
        }

        $outline->notes()->detach();
        $outline->customFields()->delete();

        $outline->delete();

        return redirect('/outlines');
    }
}
