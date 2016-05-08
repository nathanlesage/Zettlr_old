<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tag;
use App\Note;

class TagController extends Controller
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
     *  Displays a list of all tags
     *
     *  @return  Response
     */
    public function index()
    {
        // Don't only return the Tags, but also the IDs of the belonging notes, to get a count
        $tags = Tag::all();

        return view('tags.list', compact('tags'));
    }

    /**
     *  Shows a tag and displays all associated notes
     *
     *  @param   integer  $id  Tag id
     *
     *  @return  Response
     */
    public function show($id)
    {
        if(!$id || $id <= 0)
        return redirect(url('/tags/index'))->withErrors(['message' => 'No such tag']);

        $tag = Tag::find($id);

        $notes = Note::whereHas('tags', function ($query) use($id) {
            $query->where('tag_id', '=', $id);
        })->get();

        return view('tags.show', compact('notes', 'tag'));
    }

    /**
     *  Removes a tag from the database
     *
     *  @param   integer  $id  Tag id
     *
     *  @return  Response
     */
    public function delete($id)
    {
        if(!$id || $id <= 0)
        return redirect(url('/tags/index'))->withErrors(['message' => 'No such tag']);

        $tag = Tag::find($id);
        // First remove all relations to other models
        $tag->notes()->detach();
        $tag->outlines()->detach();
        // Second delete
        $tag->delete();

        return redirect(url('/tags/index'));
    }
}
