<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index() {
        // For index just output a welcome page
        return view('notes.main');
    }
    
    public function listNotes() {
        // List all notes -> get from db and then output
    }
    
    public function create() {
        // Display form to create a new note
        return view('notes.create');
    }
    
    public function insertNote(Request $request) {
        // Insert a note into the db
        $validator = Validator::make($request->all(), [
        'title' => 'required|max:255',
        'content' => 'required|min:3'
        ]);

        // If he doesn't like us show some errors
        // TODO: Insert these errors into the view
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        // Now insert via the model
    }
}