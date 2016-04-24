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
