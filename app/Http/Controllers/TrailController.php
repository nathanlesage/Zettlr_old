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

    public function index()
    {
        // Implement path finding algorithm

        // First, traverse through all notes in the database until we find a
        // note with attached notes
        $notes = Note::all();
        $firstNote = null;
        // Trails collection
        $trails = new Collection();
        foreach($notes as $note)
        {
            if(count($note->next()) > 0)
            {
                //echo $note->next();
                //$trails->push($note->notes);

                // Begin traversing with our "first level note" and pass an empty collection.
                $trails->push($this->traverseTrail($note, new Collection($note)));
            }
        }

        //$trails = $trails->flatten();
        echo $trails;
        return;

        //$trails->each(function() {});
        /*

        Problem: Does not return the first element.
        [{"id":3},{"id":5},{"id":15},{"id":17}]
        [{"id":18}][{"id":17},{"id":18}]
        [{"id":16}]
        [{"id":15}]
        [{"id":17}]
        [{"id":17},{"id":22},{"id":24}]
        [{"id":21}]
        [{"id":21},{"id":22},{"id":24}]
        [{"id":22}][]

        1 - [{"id":3},{"id":5},{"id":15},{"id":17}]
        3 - []
        5 - []
        7 - [{"id":18}]
        11 - [{"id":17},{"id":18}]
        12 - [{"id":16}]
        13 - [{"id":15}]
        15 - [{"id":17}]
        16 - [{"id":17},{"id":22},{"id":24}]
        17 - []
        18 - [{"id":21}]
        20 - [{"id":21},{"id":22},{"id":24}]
        21 - [{"id":22}]
        22 - []
        24 - []

        1 -> traverse -> 3 -> return 3 -> return 1 - 3
        1 -> traverse -> 5 -> return 5 -> return 1 - 5
        1 -> traverse -> 15 -> traverse 17 -> return 17 -> return 15 -> return 1- 15 - 17
        1 -> traverse -> 17 -> return 17 -> return 1 - 17
        7 -> traverse -> 18 -> traverse 21 -> traverse 22 -> return 22 -> return 21 -> return 18 -> return 7 - 18 - 21 - 22
        11 -> traverse -> 17 -> return 17 -> 11 - 17
        11 -> traverse -> 18 -> traverse 21 -> traverse 22 -> return 22 -> return 21 -> return 18 -> return 11 - 18 - 21 - 22
        12 -> traverse -> 16 -> return 16 -> return 12 - 16
        13 -> traverse -> 15 -> traverse 17 -> return 17 -> return 15 -> return 13 - 15 - 17
        15 -> traverse -> 17 -> return 17 -> return 15 - 17
        16 -> traverse -> 17 -> return 17 -> return 16 - 17
        16 -> traverse -> 22 -> return 22 -> return 16 - 22
        16 -> traverse -> 24 -> return 24 -> return 16 - 24
        18 -> traverse -> 21 -> traverse 22 -> return 22 -> return 21 -> return 18 - 21 - 22
        20 -> traverse -> 21 -> traverse 22 -> return 22 -> return 21 -> return 20 - 21 - 22
        20 -> traverse -> 22 -> return 22 -> return 20 - 22
        20 -> traverse -> 24 -> return 24 -> return 20 - 24
        21 -> traverse -> 22 -> return 22 -> return 21 - 22

        Should become 18 different trails.

        */


    }

    /**
    * Traverse a trail until there are no next()-notes
    *
    * @param Note $startNote
    * @param Collection &$trail
    *
    * The second parameter has to be modified every time, so it has to be passed everytime.
    * @return Collection
    */
    public function traverseTrail($startNote, $trail)
    {
        // First we get the "next" notes
        $nextNotes = $startNote->next();

        // Do we have next?
        if(count($nextNotes) > 0)
        {
            // We have many trails -> start a trailing for every note we got
            foreach($nextNotes as $n)
                $trail->push($this->traverseTrail($n, $trail->push($n)));

            return $trail;
        }
        else
        {
            // Return a collection with only the start note (i.e. the end note)
            //return new Collection($startNote);
            return $trail;
        }
    }
}
