<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tag;

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

   public function index()
   {
     $tags = Tag::all();

     return view('tags.list', compact('tags'));
   }

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
