<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Reference;

use Validator;

class ReferenceController extends Controller
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
      $references = Reference::all();

      return view('references.list', compact('references'));
  }

  public function getCreate()
  {
    return view('references.create');
  }

  public function postCreate(Request $request)
  {
    $validator = Validator::make($request->all(), [
       'title' => 'required|max:255',
       'author_first' => 'required|min:3|max:255',
       'author_last' => 'required|min:3|max:255',
       'year' => 'required|numeric'
    ]);

    if ($validator->fails()) {
       return redirect('/references/create')
                   ->withErrors($validator)
                   ->withInput();
    }

    // Begin insertion
    $reference = new Reference();
    $reference->title = $request->title;
    $reference->author_first = $request->author_first;
    $reference->author_last = $request->author_last;
    $reference->year = $request->year;
    $reference->reference_type = $request->reference_type;

    $reference->save();

    return redirect('/references/index');
  }

  public function getEdit($id)
  {
    if(!$id || $id <= 0)
      return redirect(url('/references/index'));

    $reference = Reference::find($id);

    return view('references.edit', compact('reference'));
  }

  public function postEdit(Request $request, $id)
  {
    if(!$id || $id <= 0)
      return redirect(url('/references/index'));

      $validator = Validator::make($request->all(), [
         'title' => 'required|max:255',
         'author_first' => 'required|min:3|max:255',
         'author_last' => 'required|min:3|max:255',
         'year' => 'required|numeric'
      ]);

      if ($validator->fails()) {
         return redirect('/references/edit/'.$id)
                     ->withErrors($validator)
                     ->withInput();
      }

      $reference = Reference::find($id);
      $reference->title = $request->title;
      $reference->author_first = $request->author_first;
      $reference->author_last = $request->author_last;
      $reference->year = $request->year;
      $reference->reference_type = $request->reference_type;

      $reference->save();

      return redirect('/references/index');
  }

  public function delete($id)
  {
    if(!$id || $id <= 0)
      return redirect(url('/references/index'));

    $ref = Reference::find($id);

    $ref->notes()->detach();
    $ref->outlines()->detach();

    $ref->delete();
  }
}
