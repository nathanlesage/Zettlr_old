<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function home() {
        // For home just output a welcome page
        // views/main.blade.php
        return view('main');
    }
    
    public function index() {
        // For index output a list of all notes
        // views/notes/list.blade.php
        
        // For now return an empty array
        return view('notes.list', ['notes' => '']);
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