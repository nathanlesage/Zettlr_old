<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Note;

use Illuminate\Support\Collection;

class TrailController extends Controller
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
     *  Looping function that counts all possible trails
     *
     *  @param   App\Note  $note  The note, whose trails should be searched
     *
     *  @return  integer         The current count of trails (backwards)
     */
    public function getPossibleTrails($note)
    {
        if(count($note->next()) > 0) {
            $nr = 0;
            foreach($note->next() as $next)
                $nr += $this->getPossibleTrails($next);

            return $nr;
        }
        else {
            return 1;
        }
    }

    /**
     *  Looper function that traverses all possible trails
     *
     *  @param   App\Note   $note    The current note (also a node)
     *  @param   boolean  $isRoot  Only given for the "start" note in index function
     *
     *  @return  Illuminate\Support\Collection            A collection of all notes found
     */
    public function getTrails($note, $isRoot = false)
    {
        $nextNotes = $note->next();

        if(count($nextNotes) > 0) {
            if($isRoot)
                $nr = [];
            else
                $nr = new Collection();

            foreach($nextNotes as $next)
            {
                if($isRoot)
                    $nr[] = $this->getTrails($next)->prepend($note->id);
                else
                    $nr = $nr->merge($this->getTrails($next)->prepend($note->id));
            }
            return $nr;
        }
        else {
            return new Collection($note->id);
        }
    }

    /**
     *  Searches the notes for possible trails and displays them
     *
     *  @return  Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all(['id']);
        // Trails collection
        $res = new Collection();
        foreach($notes as $note)
        {
            if(count($note->next()) > 0)
            {
                $res[] = $this->getTrails($note, true);
            }
        }

        // Eager preload all titles for the notes we have in our trails
        $noteTitles = [];
        foreach($res as $notesWithTrails)
        {
            foreach($notesWithTrails as $trailsWithNotes)
            {
                foreach($trailsWithNotes as $note)
                {
                    $tmp = Note::find($note);
                    $noteTitles[$note] = $tmp->title;
                }
            }
        }

        return view('trails.list', ["trailContainer" => $res, "noteTitles" => $noteTitles]);
    }
}
